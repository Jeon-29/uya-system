<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProposalCampaign extends Model
{
    use HasFactory;

    protected $table = 'proposal_campaigns';

    protected $fillable = [
        'title',
        'current_phase',
        'submission_deadline',
        'voting_deadline',
        'proposed_date_start',
        'proposed_date_end',
        'is_submission_override',
        'is_active',
        'required_yes_votes',
        'total_voters_target',
        'required_approval_rate',
    ];

    protected $casts = [
        'submission_deadline'    => 'datetime',
        'voting_deadline'        => 'datetime',
        'proposed_date_start'    => 'datetime',
        'proposed_date_end'      => 'datetime',
        'is_submission_override' => 'boolean',
        'is_active'              => 'boolean',
    ];

    public function getEffectivePhaseAttribute(): string
    {
        if ($this->current_phase === 'submission') {
            if ($this->is_submission_override === false) {
                return 'review';
            }

            if ($this->is_submission_override === true) {
                return 'submission';
            }

            if ($this->submission_deadline && Carbon::now()->greaterThan($this->submission_deadline)) {
                return 'review';
            }
        }

        return $this->current_phase ?? 'submission';
    }

    public function isSubmissionAllowed(): bool
    {
        return $this->effective_phase === 'submission';
    }

    public function isOwnerModificationAllowed(): bool
    {
        return in_array($this->effective_phase, ['submission', 'review']);
    }

    public function isVotingPhase(): bool
    {
        return $this->effective_phase === 'voting';
    }

    public function isClosed(): bool
    {
        return $this->effective_phase === 'closed';
    }
}

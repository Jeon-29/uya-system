<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProposalCampaign extends Model
{
    use HasFactory;

    // Explicitly declare table name
    protected $table = 'proposal_campaigns';

    protected $fillable = [
        'title',
        'current_phase',
        'submission_deadline',
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
        'proposed_date_start'    => 'datetime',
        'proposed_date_end'      => 'datetime',
        'is_submission_override' => 'boolean',
        'is_active'              => 'boolean',
    ];

    /**
     * Determine the effective phase (auto-transitions to 'review' if submission deadline passed).
     */
    public function getEffectivePhaseAttribute(): string
    {
        if ($this->current_phase === 'submission') {
            // Check override status
            if ($this->is_submission_override === false) {
                return 'review'; // Force closed by officer
            }

            if ($this->is_submission_override === true) {
                return 'submission'; // Force opened by officer
            }

            // Auto-transition check on submission deadline
            if ($this->submission_deadline && Carbon::now()->greaterThan($this->submission_deadline)) {
                return 'review';
            }
        }

        return $this->current_phase ?? 'submission';
    }

    /**
     * Helper to check if new submissions are allowed.
     */
    public function isSubmissionAllowed(): bool
    {
        return $this->effective_phase === 'submission';
    }

    /**
     * Helper to check if proposal owners can edit/delete (Locked during Voting and Closed).
     */
    public function isOwnerModificationAllowed(): bool
    {
        return in_array($this->effective_phase, ['submission', 'review']);
    }

    /**
     * Helper to check if campaign is in Voting Phase.
     */
    public function isVotingPhase(): bool
    {
        return $this->effective_phase === 'voting';
    }

    /**
     * Helper to check if campaign is Closed/Concluded.
     */
    public function isClosed(): bool
    {
        return $this->effective_phase === 'closed';
    }
}

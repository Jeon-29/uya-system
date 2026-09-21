<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Campaign extends Model
{
    protected $fillable = [
        'current_phase',
        'submission_deadline',
        'proposed_date_start',
        'proposed_date_end',
        'is_submission_override',
        'required_yes_votes',
        'total_voters_target',
    ];

    protected $casts = [
        'submission_deadline' => 'datetime',
        'proposed_date_start' => 'datetime',
        'proposed_date_end' => 'datetime',
        'is_submission_override' => 'boolean',
    ];

    /**
     * Determine effective current phase (handles auto-transition from submission -> review on deadline).
     */
    public function getEffectivePhaseAttribute(): string
    {
        // If phase is set to submission, check if deadline passed (and no force-open override is active)
        if ($this->current_phase === 'submission') {
            if ($this->is_submission_override === false) {
                return 'review'; // Force closed by admin
            }

            if ($this->is_submission_override === true) {
                return 'submission'; // Force opened by admin
            }

            // Auto-check deadline
            if ($this->submission_deadline && Carbon::now()->greaterThan($this->submission_deadline)) {
                return 'review';
            }
        }

        return $this->current_phase ?? 'submission';
    }

    /**
     * Helper to check if members can submit new proposals.
     */
    public function isSubmissionAllowed(): bool
    {
        return $this->effective_phase === 'submission';
    }

    /**
     * Helper to check if owner can edit/delete (locked during Voting & Closed).
     */
    public function isOwnerModificationAllowed(): bool
    {
        return in_array($this->effective_phase, ['submission', 'review']);
    }

    /**
     * Helper to check if campaign is in Voting phase.
     */
    public function isVotingPhase(): bool
    {
        return $this->effective_phase === 'voting';
    }

    /**
     * Helper to check if campaign is Concluded/Closed.
     */
    public function isClosed(): bool
    {
        return $this->effective_phase === 'closed';
    }
}

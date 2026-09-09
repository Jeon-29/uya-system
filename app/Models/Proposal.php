<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proposal extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'duration',
        'proposed_date',
        'voting_deadline',
        'estimated_budget',
        'status',
        'user_id',
    ];

    protected $casts = [
        'proposed_date' => 'date',
        'voting_deadline' => 'date',
    ];

    public function proposer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ProposalVote::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ProposalAttachment::class);
    }

    // Accessor for vote counts
    public function getYesCountAttribute()
    {
        if ($this->relationLoaded('votes')) {
            return $this->votes->where('vote', 'yes')->count();
        }
        return $this->votes()->where('vote', 'yes')->count();
    }

    public function getNoCountAttribute()
    {
        if ($this->relationLoaded('votes')) {
            return $this->votes->where('vote', 'no')->count();
        }
        return $this->votes()->where('vote', 'no')->count();
    }

    public function getTotalVotesAttribute()
    {
        return $this->yes_count + $this->no_count;
    }

    public function getApprovalPercentageAttribute()
    {
        if ($this->total_votes === 0) {
            return 0;
        }
        return round(($this->yes_count / $this->total_votes) * 100);
    }
}

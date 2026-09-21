<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'campaign_id',
        'user_id',
        'activity_id',
        'title',
        'description',
        'location',
        'duration',
        'proposed_date',
        'voting_deadline',
        'estimated_budget',
        'supporting_document_path',
        'is_document_validated',
        'status',
    ];

    protected $casts = [
        'proposed_date'         => 'date',
        'voting_deadline'       => 'datetime',
        'is_document_validated' => 'boolean',
        'estimated_budget'      => 'decimal:2',
    ];

    // Relationships
    public function campaign()
    {
        return $this->belongsTo(ProposalCampaign::class, 'campaign_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function votes()
    {
        return $this->hasMany(ProposalVote::class);
    }

    public function revisions()
    {
        return $this->hasMany(ProposalRevision::class)->latest();
    }

    // Helper Calculations
    public function totalVotesCount()
    {
        return $this->votes()->count();
    }

    public function yesVotesCount()
    {
        return $this->votes()->where('vote_type', 'yes')->count();
    }

    public function noVotesCount()
    {
        return $this->votes()->where('vote_type', 'no')->count();
    }

    public function approvalRatePercentage()
    {
        $total = $this->totalVotesCount();
        if ($total === 0) {
            return 0;
        }

        return round(($this->yesVotesCount() / $total) * 100);
    }
}

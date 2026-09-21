<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalRevision extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_id',
        'officer_id',
        'feedback',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}

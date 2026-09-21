<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityParticipant extends Model
{
    use HasFactory;

    protected $table = 'activity_participants';

    protected $fillable = [
        'activity_id',
        'user_id',
        'status',
        'check_in_time',
        'certificate_issued',
    ];

    protected $casts = [
        'check_in_time'      => 'datetime',
        'certificate_issued' => 'boolean',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to verify if participant was present (on-time or late).
     */
    public function isVerifiedPresent(): bool
    {
        return in_array($this->status, ['attended', 'late']);
    }
}

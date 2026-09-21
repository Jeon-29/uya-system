<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'organizer_name',
        'budget',
        'duration',
        'max_capacity',
        'status',
        'is_registration_open',
        'is_attendance_open',
        'created_by',
    ];

    protected $casts = [
        'date'                 => 'datetime',
        'budget'               => 'decimal:2',
        'is_registration_open' => 'boolean',
        'is_attendance_open'   => 'boolean',
    ];

    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', ['upcoming', 'ongoing'])
                     ->where('date', '>=', now()->toDateString());
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
        return $this->hasMany(ActivityParticipant::class);
    }

    public function photos()
    {
        return $this->hasMany(ActivityPhoto::class);
    }

    public function feedback()
    {
        return $this->hasMany(ActivityFeedback::class);
    }

    public function hasAvailableSlots(): bool
    {
        if (is_null($this->max_capacity)) {
            return true;
        }

        $activeRegistrations = $this->participants()
            ->whereIn('status', ['registered', 'attended'])
            ->count();

        return $activeRegistrations < $this->max_capacity;
    }
}

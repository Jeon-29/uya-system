<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'location',
        'status',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            ActivityParticipant::class,
            'activity_id', // Foreign key on activity_participants table...
            'id', // Foreign key on users table...
            'id', // Local key on activities table...
            'user_id' // Local key on activity_participants table...
        )->withPivot('attended');
    }

    // Alternative: direct many to many with pivot
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'activity_participants')
            ->withPivot('attended', 'created_at')
            ->withTimestamps();
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', 'upcoming')
            ->whereDate('date', '>=', today());
    }
}

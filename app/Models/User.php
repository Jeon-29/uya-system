<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'age',
    'email',
    'role',
    'gender',
    'contact_number',
    'address',
    'password',
    'failed_attempts',
    'locked_until',
    'profile_photo_path',
])]
#[Hidden(['password', 'remember_token', 'otp_code'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Generate a fresh 6-digit OTP for this user, valid for 10 minutes,
     * and persist it. Returns the plain code so it can be emailed.
     */
    public function generateOtp(): string
    {
        $code = (string) random_int(100000, 999999);

        $this->forceFill([
            'otp_code' => $code,
            'otp_expires_at' => now()->addMinutes(10),
        ])->save();

        return $code;
    }

    /**
     * Check whether the given code matches this user's active OTP.
     */
    public function otpMatches(?string $code): bool
    {
        if (blank($code) || blank($this->otp_code) || blank($this->otp_expires_at)) {
            return false;
        }

        if ($this->otp_expires_at->isPast()) {
            return false;
        }

        return hash_equals($this->otp_code, $code);
    }

    /**
     * Clear any active OTP for this user.
     */
    public function clearOtp(): void
    {
        $this->forceFill([
            'otp_code' => null,
            'otp_expires_at' => null,
        ])->save();
    }

    /**
     * Get the activities the user has joined.
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_participants')
            ->withPivot('status', 'created_at')
            ->withTimestamps();
    }

    /**
     * Get the proposals the user has created.
     */
    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    /**
     * Get the votes the user has cast on proposals.
     */
    public function proposalVotes()
    {
        return $this->hasMany(ProposalVote::class);
    }

    /**
     * Get the activity logs recorded for this user.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class)->latest();
    }

    /**
     * Get the certificates awarded to this user.
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}

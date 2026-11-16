<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'first_name',
    'middle_initial',
    'last_name',
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
     * Automatically keep the legacy `name` column synchronized whenever
     * `first_name`, `middle_initial`, or `last_name` is created or updated.
     */
    protected static function booted(): void
    {
        static::saving(function (User $user) {
            if ($user->isDirty(['first_name', 'middle_initial', 'last_name']) || blank($user->name)) {
                $first = trim((string) $user->first_name);
                $middle = trim((string) $user->middle_initial, " \t\n\r\0\x0B.");
                $last = trim((string) $user->last_name);

                if ($first !== '' || $last !== '') {
                    $user->middle_initial = $middle !== '' ? strtoupper($middle) : null;

                    $parts = array_filter([
                        $first,
                        $user->middle_initial ? $user->middle_initial . '.' : null,
                        $last,
                    ]);

                    $user->name = implode(' ', $parts);
                }
            }
        });
    }

    /**
     * Get the user's formatted full name ($user->full_name).
     */
    protected function fullName(): Attribute
    {
        return Attribute::get(function () {
            $first = trim((string) $this->first_name);
            $middle = trim((string) $this->middle_initial, " \t\n\r\0\x0B.");
            $last = trim((string) $this->last_name);

            if ($first !== '' || $last !== '') {
                return implode(' ', array_filter([
                    $first,
                    $middle !== '' ? strtoupper($middle) . '.' : null,
                    $last,
                ]));
            }

            return $this->name;
        });
    }

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

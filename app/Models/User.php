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

#[Fillable(['name', 'email', 'password', 'role', 'institution', 'phone', 'bio'])]
#[Hidden(['password', 'remember_token'])]
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
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user has admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has instructor role.
     */
    public function isInstructor(): bool
    {
        return $this->role === 'instructor' || $this->role === 'admin';
    }

    /**
     * Get user registrations.
     *
     * @return HasMany<Registration, $this>
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get user quiz attempts.
     *
     * @return HasMany<QuizAttempt, $this>
     */
    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get user certificates.
     *
     * @return HasMany<Certificate, $this>
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get user discussions.
     *
     * @return HasMany<Discussion, $this>
     */
    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    /**
     * Get user discussion replies.
     *
     * @return HasMany<DiscussionReply, $this>
     */
    public function discussionReplies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class);
    }

    /**
     * Get user simulation records.
     *
     * @return HasMany<SimulationRecord, $this>
     */
    public function simulationRecords(): HasMany
    {
        return $this->hasMany(SimulationRecord::class);
    }
}

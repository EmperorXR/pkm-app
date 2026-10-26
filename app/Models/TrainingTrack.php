<?php

namespace App\Models;

use Database\Factories\TrainingTrackFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingTrack extends Model
{
    /** @use HasFactory<TrainingTrackFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'level',
        'duration_hours',
        'instructor_name',
        'instructor_title',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'duration_hours' => 'integer',
        ];
    }

    /**
     * Get modules under this track.
     *
     * @return HasMany<TrainingModule, $this>
     */
    public function modules(): HasMany
    {
        return $this->hasMany(TrainingModule::class)->orderBy('order_number');
    }

    /**
     * Get quizzes for this track.
     *
     * @return HasMany<Quiz, $this>
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get registrations for this track.
     *
     * @return HasMany<Registration, $this>
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get certificates issued for this track.
     *
     * @return HasMany<Certificate, $this>
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get discussions under this track.
     *
     * @return HasMany<Discussion, $this>
     */
    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }
}

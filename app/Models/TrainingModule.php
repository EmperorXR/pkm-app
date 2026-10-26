<?php

namespace App\Models;

use Database\Factories\TrainingModuleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingModule extends Model
{
    /** @use HasFactory<TrainingModuleFactory> */
    use HasFactory;

    protected $fillable = [
        'training_track_id',
        'title',
        'slug',
        'summary',
        'content',
        'key_takeaways',
        'duration_minutes',
        'order_number',
        'resource_type',
        'resource_url',
    ];

    protected function casts(): array
    {
        return [
            'key_takeaways' => 'array',
            'duration_minutes' => 'integer',
            'order_number' => 'integer',
        ];
    }

    /**
     * Get parent training track.
     *
     * @return BelongsTo<TrainingTrack, $this>
     */
    public function track(): BelongsTo
    {
        return $this->belongsTo(TrainingTrack::class, 'training_track_id');
    }

    /**
     * Get quizzes for this module.
     *
     * @return HasMany<Quiz, $this>
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}

<?php

namespace App\Models;

use Database\Factories\QuizFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    /** @use HasFactory<QuizFactory> */
    use HasFactory;

    protected $fillable = [
        'training_track_id',
        'training_module_id',
        'title',
        'slug',
        'description',
        'time_limit_minutes',
        'passing_score',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'time_limit_minutes' => 'integer',
            'passing_score' => 'integer',
        ];
    }

    /**
     * Get track for this quiz.
     *
     * @return BelongsTo<TrainingTrack, $this>
     */
    public function track(): BelongsTo
    {
        return $this->belongsTo(TrainingTrack::class, 'training_track_id');
    }

    /**
     * Get module for this quiz.
     *
     * @return BelongsTo<TrainingModule, $this>
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(TrainingModule::class, 'training_module_id');
    }

    /**
     * Get questions for this quiz.
     *
     * @return HasMany<Question, $this>
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order_number');
    }

    /**
     * Get attempts for this quiz.
     *
     * @return HasMany<QuizAttempt, $this>
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }
}

<?php

namespace App\Models;

use Database\Factories\QuizAttemptFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuizAttempt extends Model
{
    /** @use HasFactory<QuizAttemptFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'correct_count',
        'total_questions',
        'is_passed',
        'answers_payload',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'float',
            'correct_count' => 'integer',
            'total_questions' => 'integer',
            'is_passed' => 'boolean',
            'answers_payload' => 'array',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Get user who took the quiz.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get quiz taken.
     *
     * @return BelongsTo<Quiz, $this>
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get certificate linked to this attempt.
     *
     * @return HasOne<Certificate, $this>
     */
    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }
}

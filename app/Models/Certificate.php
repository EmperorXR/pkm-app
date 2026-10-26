<?php

namespace App\Models;

use Database\Factories\CertificateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    /** @use HasFactory<CertificateFactory> */
    use HasFactory;

    protected $fillable = [
        'certificate_number',
        'verify_code',
        'user_id',
        'training_track_id',
        'quiz_attempt_id',
        'final_score',
        'issue_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'final_score' => 'float',
            'issue_date' => 'date',
        ];
    }

    /**
     * Get owner of the certificate.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get training track.
     *
     * @return BelongsTo<TrainingTrack, $this>
     */
    public function track(): BelongsTo
    {
        return $this->belongsTo(TrainingTrack::class, 'training_track_id');
    }

    /**
     * Get quiz attempt that granted the certificate.
     *
     * @return BelongsTo<QuizAttempt, $this>
     */
    public function quizAttempt(): BelongsTo
    {
        return $this->belongsTo(QuizAttempt::class);
    }
}

<?php

namespace App\Models;

use Database\Factories\RegistrationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    /** @use HasFactory<RegistrationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_track_id',
        'registration_code',
        'status',
        'registered_at',
        'attended',
        'motivation_reason',
        'prior_experience',
    ];

    protected function casts(): array
    {
        return [
            'attended' => 'boolean',
            'registered_at' => 'datetime',
        ];
    }

    /**
     * Get user who registered.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get training track registered for.
     *
     * @return BelongsTo<TrainingTrack, $this>
     */
    public function track(): BelongsTo
    {
        return $this->belongsTo(TrainingTrack::class, 'training_track_id');
    }
}

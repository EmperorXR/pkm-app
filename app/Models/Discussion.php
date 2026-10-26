<?php

namespace App\Models;

use Database\Factories\DiscussionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discussion extends Model
{
    /** @use HasFactory<DiscussionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_track_id',
        'title',
        'content',
        'category',
        'is_resolved',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'is_resolved' => 'boolean',
            'views_count' => 'integer',
        ];
    }

    /**
     * Get discussion author.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get discussion training track.
     *
     * @return BelongsTo<TrainingTrack, $this>
     */
    public function track(): BelongsTo
    {
        return $this->belongsTo(TrainingTrack::class, 'training_track_id');
    }

    /**
     * Get discussion replies.
     *
     * @return HasMany<DiscussionReply, $this>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class)->oldest();
    }
}

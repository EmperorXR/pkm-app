<?php

namespace App\Models;

use Database\Factories\DiscussionReplyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscussionReply extends Model
{
    /** @use HasFactory<DiscussionReplyFactory> */
    use HasFactory;

    protected $fillable = [
        'discussion_id',
        'user_id',
        'content',
        'is_instructor_answer',
    ];

    protected function casts(): array
    {
        return [
            'is_instructor_answer' => 'boolean',
        ];
    }

    /**
     * Get parent discussion.
     *
     * @return BelongsTo<Discussion, $this>
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * Get author of the reply.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

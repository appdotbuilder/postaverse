<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property int|null $parent_id
 * @property string $content
 * @property array|null $media
 * @property int $likes_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\Comment|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $replies
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment topLevel()
 * @method static \Database\Factories\CommentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'content',
        'media',
        'likes_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'media' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'likes_count' => 'integer',
    ];

    /**
     * Get the user that wrote the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that the comment belongs to.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the parent comment.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the comment replies.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Get all of the comment's likes.
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Scope a query to only include top-level comments.
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Check if the comment has media attachments.
     */
    public function hasMedia(): bool
    {
        return !empty($this->media);
    }

    /**
     * Check if this is a reply to another comment.
     */
    public function isReply(): bool
    {
        return !is_null($this->parent_id);
    }
}
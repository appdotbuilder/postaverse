<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $user_id
 * @property string $content
 * @property array|null $media
 * @property string $privacy
 * @property int $likes_count
 * @property int $comments_count
 * @property int $shares_count
 * @property bool $is_pinned
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePrivacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post published()
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'content',
        'media',
        'privacy',
        'likes_count',
        'comments_count',
        'shares_count',
        'is_pinned',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'media' => 'array',
        'is_pinned' => 'boolean',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'shares_count' => 'integer',
    ];

    /**
     * Get the user that owns the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the post.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all of the post's likes.
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include public posts.
     */
    public function scopePublic($query)
    {
        return $query->where('privacy', 'public');
    }

    /**
     * Check if the post has media attachments.
     */
    public function hasMedia(): bool
    {
        return !empty($this->media);
    }

    /**
     * Get the post's excerpt.
     */
    public function getExcerptAttribute(): string
    {
        return str($this->content)->limit(150);
    }
}
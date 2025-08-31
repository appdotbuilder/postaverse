<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $bio
 * @property string|null $avatar
 * @property string|null $cover_image
 * @property string|null $location
 * @property string|null $website
 * @property string|null $birth_date
 * @property string $privacy
 * @property bool $is_admin
 * @property \Illuminate\Support\Carbon|null $last_active_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $sentMessages
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $receivedMessages
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $followers
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $following
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $createdGroups
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'avatar',
        'cover_image',
        'location',
        'website',
        'birth_date',
        'privacy',
        'is_admin',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'last_active_at' => 'datetime',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the user's posts.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the messages sent by this user.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get the messages received by this user.
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    /**
     * Get the users that follow this user.
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
                    ->wherePivot('status', 'approved')
                    ->withTimestamps();
    }

    /**
     * Get the users that this user follows.
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
                    ->wherePivot('status', 'approved')
                    ->withTimestamps();
    }

    /**
     * Get the groups this user belongs to.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_members')
                    ->wherePivot('status', 'approved')
                    ->withPivot(['role', 'status'])
                    ->withTimestamps();
    }

    /**
     * Get the groups created by this user.
     */
    public function createdGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'creator_id');
    }

    /**
     * Get the user's comments.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the user's likes.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('last_active_at')
                     ->where('last_active_at', '>', now()->subDays(30));
    }

    /**
     * Get the user's display name.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->username ? '@' . $this->username : $this->name;
    }

    /**
     * Get the user's follower count.
     */
    public function getFollowersCountAttribute(): int
    {
        return $this->followers()->count();
    }

    /**
     * Get the user's following count.
     */
    public function getFollowingCountAttribute(): int
    {
        return $this->following()->count();
    }
}
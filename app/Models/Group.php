<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Group
 *
 * @property int $id
 * @property int $creator_id
 * @property string $name
 * @property string $description
 * @property string|null $cover_image
 * @property string $privacy
 * @property int $members_count
 * @property array|null $rules
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group wherePrivacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group active()
 * @method static \Database\Factories\GroupFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'creator_id',
        'name',
        'description',
        'cover_image',
        'privacy',
        'members_count',
        'rules',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rules' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'members_count' => 'integer',
    ];

    /**
     * Get the user that created the group.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the group members.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->wherePivot('status', 'approved')
                    ->withPivot(['role', 'status'])
                    ->withTimestamps();
    }

    /**
     * Scope a query to only include active groups.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include public groups.
     */
    public function scopePublic($query)
    {
        return $query->where('privacy', 'public');
    }

    /**
     * Get the group's member count.
     */
    public function getMembersCountAttribute(): int
    {
        return $this->members()->count();
    }
}
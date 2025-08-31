<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $groupTypes = [
            'Photography Enthusiasts',
            'Web Developers',
            'Book Lovers',
            'Fitness Community',
            'Travel Adventures',
            'Food & Recipes',
            'Gaming Hub',
            'Art & Design',
            'Music Lovers',
            'Tech Innovators'
        ];

        return [
            'creator_id' => User::factory(),
            'name' => fake()->randomElement($groupTypes) . ' - ' . fake()->city(),
            'description' => fake()->paragraphs(random_int(2, 4), true),
            'cover_image' => fake()->boolean(70) ? fake()->imageUrl(800, 400, 'business') : null,
            'privacy' => fake()->randomElement(['public', 'private', 'secret']),
            'members_count' => fake()->numberBetween(1, 5000),
            'rules' => fake()->boolean(80) ? [
                'Be respectful to all members',
                'No spam or self-promotion',
                'Keep discussions on topic',
                'Follow community guidelines'
            ] : null,
            'is_active' => fake()->boolean(95),
        ];
    }

    /**
     * Indicate that the group is popular.
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'members_count' => fake()->numberBetween(1000, 10000),
            'privacy' => 'public',
        ]);
    }

    /**
     * Indicate that the group is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'privacy' => 'private',
        ]);
    }

    /**
     * Indicate that the group is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
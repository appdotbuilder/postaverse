<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'content' => fake()->paragraphs(random_int(1, 3), true),
            'media' => fake()->boolean(30) ? [
                fake()->imageUrl(640, 480, 'nature'),
                fake()->imageUrl(640, 480, 'city')
            ] : null,
            'privacy' => fake()->randomElement(['public', 'friends', 'private']),
            'likes_count' => fake()->numberBetween(0, 500),
            'comments_count' => fake()->numberBetween(0, 50),
            'shares_count' => fake()->numberBetween(0, 25),
            'is_pinned' => fake()->boolean(5),
            'published_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'created_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    /**
     * Indicate that the post is popular.
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'likes_count' => fake()->numberBetween(100, 1000),
            'comments_count' => fake()->numberBetween(20, 100),
            'shares_count' => fake()->numberBetween(10, 50),
        ]);
    }

    /**
     * Indicate that the post has media.
     */
    public function withMedia(): static
    {
        return $this->state(fn (array $attributes) => [
            'media' => [
                fake()->imageUrl(640, 480, 'nature'),
                fake()->imageUrl(640, 480, 'animals'),
                fake()->imageUrl(640, 480, 'food'),
            ],
        ]);
    }

    /**
     * Indicate that the post is pinned.
     */
    public function pinned(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_pinned' => true,
        ]);
    }

    /**
     * Indicate that the post is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'privacy' => 'private',
        ]);
    }
}
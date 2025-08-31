<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'post_id' => Post::factory(),
            'parent_id' => null,
            'content' => fake()->sentence(random_int(3, 15)),
            'media' => fake()->boolean(10) ? [
                fake()->imageUrl(300, 200, 'cats')
            ] : null,
            'likes_count' => fake()->numberBetween(0, 50),
        ];
    }

    /**
     * Indicate that the comment is a reply.
     */
    public function reply(): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_id' => \App\Models\Comment::factory(),
        ]);
    }

    /**
     * Indicate that the comment has media.
     */
    public function withMedia(): static
    {
        return $this->state(fn (array $attributes) => [
            'media' => [
                fake()->imageUrl(300, 200, 'animals'),
            ],
        ]);
    }

    /**
     * Indicate that the comment is popular.
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'likes_count' => fake()->numberBetween(20, 200),
        ]);
    }
}
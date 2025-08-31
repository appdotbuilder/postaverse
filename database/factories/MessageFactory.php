<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isRead = fake()->boolean(70);

        return [
            'sender_id' => User::factory(),
            'recipient_id' => User::factory(),
            'content' => fake()->sentence(random_int(3, 20)),
            'media' => fake()->boolean(20) ? [
                fake()->imageUrl(400, 300, 'people')
            ] : null,
            'is_read' => $isRead,
            'read_at' => $isRead ? fake()->dateTimeBetween('-7 days', 'now') : null,
        ];
    }

    /**
     * Indicate that the message is unread.
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Indicate that the message has media.
     */
    public function withMedia(): static
    {
        return $this->state(fn (array $attributes) => [
            'media' => [
                fake()->imageUrl(400, 300, 'nature'),
                fake()->imageUrl(400, 300, 'city'),
            ],
        ]);
    }

    /**
     * Indicate that the message is recent.
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_at' => fake()->dateTimeBetween('-1 hour', 'now'),
        ]);
    }
}
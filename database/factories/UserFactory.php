<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->boolean(70) ? fake()->unique()->userName() : null,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'bio' => fake()->boolean(60) ? fake()->sentence(random_int(10, 30)) : null,
            'avatar' => fake()->boolean(40) ? fake()->imageUrl(200, 200, 'people') : null,
            'cover_image' => fake()->boolean(30) ? fake()->imageUrl(800, 300, 'nature') : null,
            'location' => fake()->boolean(50) ? fake()->city() . ', ' . fake()->country() : null,
            'website' => fake()->boolean(20) ? fake()->url() : null,
            'birth_date' => fake()->boolean(60) ? fake()->dateTimeBetween('-80 years', '-13 years')->format('Y-m-d') : null,
            'privacy' => fake()->randomElement(['public', 'private']),
            'is_admin' => fake()->boolean(5),
            'last_active_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_admin' => true,
        ]);
    }

    /**
     * Indicate that the user has a complete profile.
     */
    public function withCompleteProfile(): static
    {
        return $this->state(fn (array $attributes) => [
            'username' => fake()->unique()->userName(),
            'bio' => fake()->paragraphs(2, true),
            'avatar' => fake()->imageUrl(200, 200, 'people'),
            'cover_image' => fake()->imageUrl(800, 300, 'nature'),
            'location' => fake()->city() . ', ' . fake()->country(),
            'website' => fake()->url(),
            'birth_date' => fake()->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the user is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'privacy' => 'private',
        ]);
    }
}
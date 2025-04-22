<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use k1fl1k\truefalsegame\Enum\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\k1fl1k\truefalsegame\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'id' => (string) Str::ulid(), // Generate ULID
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'), // Default password
            'remember_token' => Str::random(10),
            'role' => Role::USER->value, // Default role as USER
            'avatar' => asset('storage/images/' . 'user.svg'), // Random avatar image
            'description' => fake()->sentence(15), // Short user description
        ];
    }

    /**
     * Indicate that the user should be an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::ADMIN->value,
        ]);
    }

    /**
     * Indicate that the user should have an unverified email.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

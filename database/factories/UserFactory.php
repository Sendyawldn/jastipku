<?php

// database/factories/UserFactory.php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password default: "password"
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'role' => 'penitip', // Default role
            'rating' => fake()->randomFloat(1, 4.0, 5.0),
            'total_reviews' => fake()->numberBetween(5, 50),
            'remember_token' => Str::random(10),
        ];
    }

    // State untuk membuat traveler
    public function traveler(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'traveler',
        ]);
    }

    // State untuk membuat admin
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin',
        ]);
    }
}

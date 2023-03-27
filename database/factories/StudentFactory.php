<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'cpf' => sprintf('%03d.%03d.%03d-%02d', rand(0, 999), rand(0, 999), rand(0, 999), rand(0, 99)),
            'rg' => fake()->unique()->numberBetween(100000, 999999999999999999),
            'birth' => fake()->dateTimeBetween(now()->subYears(70), now()->subYears(15)),
            'personal_email' => fake()->safeEmail(),
            'institutional_email' => fake()->safeEmail(),
        ];
    }
}

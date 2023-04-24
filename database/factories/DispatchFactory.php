<?php

namespace Database\Factories;

use App\Models\Requirement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dispatch>
 */
class DispatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => rand(2, 3),
            'text' => fake()->sentence(),
            'observation' => fake()->sentence(),
            'user_id' => User::all()->random()->id,
            'requirement_id' => Requirement::all()->random()->id,
        ];
    }
}

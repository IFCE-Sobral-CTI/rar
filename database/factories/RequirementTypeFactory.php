<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RequirementType>
 */
class RequirementTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(2),
            'status' => !!rand(1, 2), // 1 = active, 2 = inactive
            'printable' => !!rand(1, 2), // 1 = yes, 2 = no
        ];
    }
}

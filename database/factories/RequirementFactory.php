<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\RequirementType;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Requirement>
 */
class RequirementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reqType = RequirementType::all()->random();

        if ($reqType->description == 'Segunda via')
            $justification = fake()->sentence();

        return [
            'status' => rand(1, 3),
            'justification' => $justification?? null,
            'requirement_type_id' => $reqType->id,
            'enrollment_id' => Enrollment::all()->random()->id,
            'semester_id' => Semester::all()->random()->id,
            'created_at' => fake()->dateTimeBetween('2023-05-11'),
        ];
    }
}

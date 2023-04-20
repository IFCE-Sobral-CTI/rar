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
        return [
            'status' => rand(1, 3),
            'requirement_type_id' => RequirementType::all()->random()->id,
            'enrollment_id' => Enrollment::all()->random()->id,
            'semester_id' => Semester::all()->random()->id,
        ];
    }
}

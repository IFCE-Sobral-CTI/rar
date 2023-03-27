<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $course = Course::all()->random();

        return [
            'number' => sprintf('%d%d%05d%04d', rand(2014, 2023), rand(1, 2), $course->number, rand(1, 200)),
            'student_id' => Student::all()->random()->id,
            'course_id' => $course->id,
            'status' => !!rand(0, 1),
        ];
    }
}

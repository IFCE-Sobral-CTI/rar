<?php

namespace Database\Seeders;

use App\Enums\LevelOfEducation;
use App\Models\CourseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseType::insert([
            ['description' => 'Técnico', 'level' => LevelOfEducation::technical, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Tecnológico', 'level' => LevelOfEducation::higher, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Licenciatura', 'level' => LevelOfEducation::higher, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Bacharel', 'level' => LevelOfEducation::higher, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Especialização', 'level' => LevelOfEducation::higher, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Mestrado', 'level' => LevelOfEducation::higher, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

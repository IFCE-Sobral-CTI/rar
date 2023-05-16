<?php

namespace Database\Seeders;

use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Semester::insert([
            ['description' => '2023.1', 'start' => '2023-01-01', 'end' => '2023-06-30', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}

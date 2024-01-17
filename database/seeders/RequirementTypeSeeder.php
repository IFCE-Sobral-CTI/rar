<?php

namespace Database\Seeders;

use App\Models\RequirementType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequirementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RequirementType::insert([
            ['description' => 'Primeira via', 'status' => 1, 'printable' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Segunda via', 'status' => 1, 'printable' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Renovação', 'status' => 1, 'printable' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

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
            ['description' => 'Primeira via', 'status' => true, 'printable' => true, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Segunda via', 'status' => true, 'printable' => true, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Renovação', 'status' => true, 'printable' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

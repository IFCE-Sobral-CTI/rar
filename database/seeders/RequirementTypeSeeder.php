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
        RequirementType::factory(26)->create();
    }
}

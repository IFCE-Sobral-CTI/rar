<?php

namespace Database\Seeders;

use App\Models\Dispatch;
use App\Models\Requirement;
use App\Models\Weekday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Requirement::factory(22)->create()->each(function($requirement) {
            $requirement->weekdays()->sync(
                Weekday::where('status', true)->get()
            );
            $requirement->dispatches()->saveMany(
                Dispatch::factory(rand(1, 5))->make(['requirement_id' => null])
            );
        });
    }
}

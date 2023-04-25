<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Requirement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::factory(4)->create()->each(function($report) {
            $report->requirements()->sync(
                Requirement::where('status', 2)->get()->random(4)
            );
        });
    }
}

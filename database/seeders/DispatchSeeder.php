<?php

namespace Database\Seeders;

use App\Models\Dispatch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DispatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dispatch::factory(25)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\PrintQueue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrintQueueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrintQueue::factory(30)->create();
    }
}

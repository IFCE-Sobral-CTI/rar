<?php

namespace Database\Seeders;

use App\Models\Weekday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeekdaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Weekday::insert([
            ['description' => 'Domingo', 'status' => false, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Segunda-feira', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Terça-feira', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Quarta-feira', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Quinta-feira', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Sexta-feira', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['description' => 'Sábado', 'status' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

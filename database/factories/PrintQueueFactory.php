<?php

namespace Database\Factories;

use App\Models\Dispatch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrintQueue>
 */
class PrintQueueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dispatch_id' => Dispatch::all()->random()->id,
        ];
    }
}

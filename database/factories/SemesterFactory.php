<?php

namespace Database\Factories;

use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use stdClass;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Semester>
 */
class SemesterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = $this->getData(fake()->numberBetween(2013, 2023).'.'.fake()->numberBetween(1, 2));

        return [
            'description' => $data->description,
            'start' => $this->getStart($data),
            'end' => $this->getEnd($data),
        ];
    }

    private function getStart(Object $data): string
    {
        $start = (object)[
            'year' => $data->year,
            'month' => $data->semester == 1? 1: 7,
            'day' => 1,
        ];

        return Carbon::create($start->year, $start->month, $start->day)->format('m-d-Y');
    }

    private function getEnd(Object $data): string
    {

        $end = (object)[
            'year' => $data->year,
            'month' => $data->semester == 1? 6: 12,
            'day' => $data->semester == 1? 30: 31,
        ];

        return Carbon::create($end->year, $end->month, $end->day)->format('m-d-Y');
    }

    /**
     * Year and semester used in description Semester model
     */
    private function getData(string $description = null): object
    {
        $description = $description?? '2013.1';

        $result = new stdClass;
        // Verifica qual semestre está para gerar os dados
        if (substr($description, -1) == 1) {
            // Seta o ano
            $result->year = ((int)substr($description, 0, 4));
            // Seta o próximo semestre
            $result->semester = 2;
        } else {
            // Seta o próximo ano
            $result->year = ((int)substr($description, 0, 4)) + 1;
            // Seta o próximo semester
            $result->semester = 1;
        }

        // Seta a descrição do próximo semestre
        $result->description = "$result->year.$result->semester";

        return $result;
    }
}

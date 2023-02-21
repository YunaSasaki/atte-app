<?php

namespace Database\Factories;

use App\Models\Stamp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rest>
 */
class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $time = fake()->dateTimeBetween('1970-01-01 00:00:00', '1970-01-01 12:00:00');
        $rest_time = "+" .rand(10, 30) ."minute";
        return [
            'start_rest' => $time->format('H:i:s'),
            'end_rest' => $time->modify($rest_time)->format('H:i:s'),
        ];
    }
}

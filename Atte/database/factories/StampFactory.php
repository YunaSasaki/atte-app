<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stamp>
 */
class StampFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = fake()->dateTimeBetween('-1 week', 'now');
        $time = fake()->dateTimeBetween('1970-01-01 00:00:00', '1970-01-01 12:00:00');
        $work_time = "+" .rand(1,10). "hours";
        return [
            'user_id' => rand(1,10),
            'stamp_date' => $date->format('Y-m-d'),
            'start_work' => $time->format('H:i:s'),
            'end_work' => $time->modify($work_time)->format('H:i:s'),
        ];
    }
}

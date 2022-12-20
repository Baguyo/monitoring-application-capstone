<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonitoringRecord>
 */
class MonitoringRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
            'date' => Carbon::now()->timezone('Asia/Singapore')->format('Y-m-d'),
            'first_in' => fake()->time(),
            'first_out' => fake()->time(),
            'second_in' => fake()->time(),
            'second_out' => fake()->time(),
            'third_in' => fake()->time(),
            'third_out' => fake()->time(),
            'fourth_in' => fake()->time(),
            'fourth_out' => fake()->time(),
            'fifth_in' => fake()->time(),
            'fifth_out' => fake()->time(),
        ];
    }
}

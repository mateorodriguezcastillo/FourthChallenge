<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'departure_date' => fake()->dateTimeBetween('-1 year', today()),
            'arrival_date' => fake()->dateTimeBetween(today(), '+1 year'),
        ];
    }
}

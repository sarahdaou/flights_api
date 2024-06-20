<?php

namespace Database\Factories;

use App\Models\Flight;
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
    protected $model = Flight::class;

    public function definition(): array
    {

        $departure_time = $this->faker->dateTimeBetween('now', '+1 month');
        $arrival_time = $this->faker->dateTimeBetween($departure_time, $departure_time->format('Y-m-d H:i:s').'+19 hours');

        return [
            'number' =>$this->faker->unique()->numerify('FL####'),
            'departure_city' => $this->faker->city,
            'arrival_city' => $this->faker->city,
            'departure_time' => $departure_time,
            'arrival_time' => $arrival_time,
        ];
    }
}

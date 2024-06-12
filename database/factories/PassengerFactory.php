<?php

namespace Database\Factories;

use App\Models\Passenger;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Passenger>
 */
class PassengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Passenger::class;
     
    public function definition(): array
    {
        return [
        'first_name'=> $this->faker->firstName(),
        'last_name' => $this->faker->lastName(),
        'email' => $this->faker->unique()->safeEmail,
        'password' => $this->faker->password(),
        'date_of_birth' => $this->faker->date(),
        'passport_expiry_date' => $this->faker->date(),
        
        ];
    }
}

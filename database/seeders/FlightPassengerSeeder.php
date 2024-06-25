<?php

namespace Database\Seeders;

use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FlightPassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flights = Flight::all();
        $passengers = Passenger::all();

        $passengers->each(function($passenger) use ($flights) {
           
            $passenger->flights()->attach(
                $flights->random(rand(1, 3))->pluck('id')->toArray(),
                ['created_at' => now(), 'updated_at' => now()]
            );
        });
    }
}

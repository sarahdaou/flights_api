<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    // public function allFlights()
    // {
    //     // Retrieve all flights with passengers eager loaded
    //     $flights = Flight::with('passengers')->get();

    //     return response()->json($flights);
    // }
}

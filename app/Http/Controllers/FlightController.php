<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        // Define allowed filters and sorts
        $flights = QueryBuilder::for(Flight::class)
            ->allowedFilters([
                AllowedFilter::exact('departure_city'),
                AllowedFilter::exact('arrival_city'),
                AllowedFilter::scope('departure_after', 'departure_time_after'),
                AllowedFilter::scope('arrival_before', 'arrival_time_before'),
            ])
            ->allowedSorts(['number', 'departure_time', 'arrival_time'])
            ->paginate($request->get('per_page', 10));

        return response()->json($flights);
    }

    public function show($id)
    {
        $flight = Flight::findOrFail($id);
        return response()->json($flight);
    }
}

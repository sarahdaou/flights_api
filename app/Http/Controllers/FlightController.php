<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $flights = QueryBuilder::for(Flight::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('number'),
                AllowedFilter::partial('departure_city'),
                AllowedFilter::partial('arrival_city'),
                AllowedFilter::partial('departure_time'),
                AllowedFilter::partial('arrival_time'),
            ])
            ->allowedSorts(['id','number', 'departure_city', 'arrival_city', 'departure_time', 'arrival_time'])
            ->with('passengers') 
            ->paginate($request->get('per_page', 20));

        return response()->json($flights);
    }

    public function show(Flight $flight)
    {
        return response()->json($flight->load('passengers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|unique:flights,number',
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
        ]);

        $flight = Flight::create($validatedData);

        return response()->json($flight);
    }

    public function update(Request $request, Flight $flight)
    {
        $validatedData = $request->validate([
            'number' => 'required|unique:flights,number,' . $flight->id,
            'departure_city' => 'required',
            'arrival_city' => 'required',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
        ]);

        $flight->update($validatedData);

        return response()->json($flight);
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();

        return response()->json(['message' => 'Flight deleted']);
    }
}
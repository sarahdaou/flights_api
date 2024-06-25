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
            ->paginate($request->get('per_page', 100));

        return response()->json($flights);
    }
}
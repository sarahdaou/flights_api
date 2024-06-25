<?php 

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class PassengerController extends Controller
{
    public function index(Request $request)
    {
        $passengers = QueryBuilder::for(Passenger::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('first_name'),
                AllowedFilter::partial('last_name'),
                AllowedFilter::partial('email'),
                AllowedFilter::exact('date_of_birth'),
                AllowedFilter::exact('passport_expiry_date'),
            ])
            ->allowedSorts(['id','first_name', 'last_name', 'email', 'date_of_birth', 'passport_expiry_date'])
            ->paginate($request->get('per_page', 20));

        return response()->json($passengers);
    }

    public function flights($passengerId)
    {
        // Retrieve the passenger by ID
        $passenger = Passenger::findOrFail($passengerId);

        // Eager load flights associated with the passenger
        $passenger->load('flights');

        return response()->json($passenger->flights);
    }
}
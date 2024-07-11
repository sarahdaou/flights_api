<?php 

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use App\Exports\PassengerExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
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
            ->with('flights')
            ->paginate($request->get('per_page', 20));

            $passengers = Cache::remember('passengers', 3600, function () {
                return Passenger::all();
            });

        return response()->json($passengers);
    }

    public function show(Passenger $passenger)
    {
        return response()->json($passenger->load('flights'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'date_of_birth' => 'required|date',
            'passport_expiry_date' => [
                'required',
                'date',
                'after:' . now()->addYear()->toDateString(),
                'before:' . now()->addYears(10)->toDateString(),
            ],
        ]);

        $passenger = Passenger::create($validatedData);

        Cache::forget('passengers');

        return response()->json($passenger);
    }

    public function update(Request $request, Passenger $passenger)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'date_of_birth' => 'required|date',
            'passport_expiry_date' => [
                'required',
                'date',
                'after:' . now()->addYear()->toDateString(),
                'before:' . now()->addYears(10)->toDateString(),
            ],
        ]);

        $passenger->update($validatedData);

        Cache::forget('passengers');

        return response()->json($passenger);
    }

    public function destroy(Passenger $passenger)
    {
        $passenger->delete();

        Cache::forget('passengers');

        return response()->json(['message' => 'Passenger deleted']);
    }

    public function export()
    {
        return Excel::download(new PassengerExport, 'passengers.xlsx');
    }

}
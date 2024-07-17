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
        $cacheKey = 'passengers_' . md5(json_encode($request->query()));
        $passengers = Cache::remember($cacheKey, 3600, function () use ($request) {
            return QueryBuilder::for(Passenger::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    'first_name',
                    'last_name',
                    'email',
                    AllowedFilter::exact('date_of_birth'),
                    AllowedFilter::exact('passport_expiry_date'),
                ])
                ->allowedSorts(['first_name','created_at'])
                ->defaultSorts('updated_at')
                ->with('flights')
                ->paginate($request->get('per_page', 20));
        });
    
        return response($passengers);
    }

    public function show(Passenger $passenger)
    {
        return response($passenger->load('flights'));
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

        return response($passenger);
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

        return response($passenger);
    }

    public function destroy(Passenger $passenger)
    {
        $passenger->delete();

        return response(['message' => 'Passenger deleted']);
    }

    public function export()
    {
        return Excel::download(new PassengerExport, 'passengers.xlsx');
    }

}
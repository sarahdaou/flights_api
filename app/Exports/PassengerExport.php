<?php

namespace App\Exports;

use App\Models\Passenger;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PassengerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Adjust the fields to exclude sensitive data like password
        return Passenger::select('first_name', 'last_name', 'email', 'date_of_birth', 'passport_expiry_date')->get();
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Date of Birth',
            'Passport Expiry Date',
            'Created at',
            'Updated at'
        ];
    }
}


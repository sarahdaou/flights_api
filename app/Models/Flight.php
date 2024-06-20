<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Flight extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'timestamps'
    ];

    public function passengers(): BelongsToMany
    {
        return $this->belongsToMany(Passenger::class, 'flight_passenger');
    }

};

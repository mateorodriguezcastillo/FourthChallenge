<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline_id',
        'origin_id',
        'destination_id',
        'departure_date',
        'arrival_date',
    ];

    public function scopeFilter($query, $filters)
    {
        //where city is origin or city is destination
        $query->when($filters['city'] ?? false, fn ($query, $city) =>
            $query->whereHas('origin', fn ($query) =>
                $query->where('id', $city)
            )->orWhereHas('destination', fn ($query) =>
                $query->where('id', $city)
            )
        );
    }

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function origin()
    {
        return $this->belongsTo(City::class, 'origin_id');
    }

    public function destination()
    {
        return $this->belongsTo(City::class, 'destination_id');
    }
}

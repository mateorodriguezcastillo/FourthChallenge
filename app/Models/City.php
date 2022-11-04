<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class City extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'name',
    ];

    public $sortable = [
        'id',
        'name',
    ];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['airline'] ?? false, fn ($query, $airline) =>
            $query->whereHas('airlines', fn ($query) =>
                $query->where('airline_id', $airline)
            )
        );
    }

    public function airlines()
    {
        return $this->belongsToMany(Airline::class);
    }

    public function departing_flights()
    {
        return $this->hasMany(Flight::class, 'origin_id');
    }

    public function arriving_flights()
    {
        return $this->hasMany(Flight::class, 'destination_id');
    }

    public function getDepartingFlightsCountAttribute()
    {
        return $this->departing_flights()->count();
    }

    public function getArrivingFlightsCountAttribute()
    {
        return $this->arriving_flights()->count();
    }
}

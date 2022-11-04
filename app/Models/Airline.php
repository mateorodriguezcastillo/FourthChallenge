<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['city'] ?? false, fn ($query, $city) =>
            $query->whereHas('cities', fn ($query) =>
                $query->where('city_id', $city)
            )
        );
    }

    public function cities()
    {
        return $this->belongsToMany(City::class);
    }

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function getFlightsCountAttribute()
    {
        return $this->flights()->count();
    }
}

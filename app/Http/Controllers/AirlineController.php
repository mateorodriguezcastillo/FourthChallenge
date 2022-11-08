<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAirlineRequest;
use App\Http\Requests\UpdateAirlineRequest;
use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index()
    {
        return view('airlines.index');
    }

    public function get()
    {
        $airlines = Airline::filter(request(['city']))
            ->withCount('flights')
            ->paginate(8)
            ->withQueryString();

        return response()->json($airlines);
    }

    public function getAirline(Airline $airline)
    {
        return response()->json($airline->load('cities'));
    }

    public function getAll()
    {
        $airlines = Airline::with('cities')->get();

        return response()->json($airlines);
    }

    public function store(StoreAirlineRequest $request)
    {
        Airline::create($request->all());
        $airlines = Airline::filter(request(['city']))
        ->withCount('flights')->paginate(8)->withQueryString();
        return response()->json($airlines);
    }

    public function update(UpdateAirlineRequest $request, Airline $airline)
    {
        $airline->update($request->all());
        $airlines = Airline::filter(request(['city']))
        ->withCount('flights')->paginate(8)->withQueryString();
        return response()->json($airlines);
    }

    public function destroy(Airline $airline)
    {
        if ($airline) {
            $airline->delete();
            $airlines = Airline::filter(request(['city']))
            ->withCount('flights')->paginate(8)->withQueryString();
            return response()->json($airlines);
        }
    }
}

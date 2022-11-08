<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index()
    {
        return view('flights.index');
    }

    public function get(){
        $flights = Flight::with('airline', 'origin', 'destination')->paginate(8);

        return response()->json($flights);
    }

    public function store(Request $request)
    {
        $flight = Flight::create($request->all());
        return response()->json($flight);
    }

    public function show(Flight $flight)
    {
        return response()->json($flight);
    }

    public function update(Request $request, Flight $flight)
    {
        $flight->update($request->all());
        return response()->json($flight);
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return response()->json($flight);
    }
}

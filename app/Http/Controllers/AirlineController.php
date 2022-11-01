<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index()
    {
        $airlines = Airline::all();

        return view('airlines.index', [
            'airlines' => $airlines,
        ]);
    }
}

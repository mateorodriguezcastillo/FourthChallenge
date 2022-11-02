<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Models\City;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $cities = City::sortable()->paginate(15)->withQueryString();
            return response()->json([
                'success' => true,
                'cities' => $cities,
            ]);
        }
        return view('cities.index');
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(StoreCityRequest $request)
    {
        City::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'City created successfully.',
        ]);
    }

    public function edit(City $city)
    {
        return response()->json([
            'success' => true,
            'cities' => $city,
        ]);
    }

    public function update(StoreCityRequest $request, City $city)
    {
        $city->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'City updated successfully.',
        ]);
    }

    public function destroy(City $city)
    {
        if ($city) {
            $city->delete();
            return response()->json([
                'success' => true,
                'message' => 'City deleted successfully.',
            ]);
        }
    }
}

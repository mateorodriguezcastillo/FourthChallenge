<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Models\City;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cities = City::latest()->get();

            return DataTables::of($cities)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                //->addIndexColumn()
                ->make(true);
        }

        return view('testCities');
    }

    public function store(StoreCityRequest $request)
    {
        $request->validated();

        City::updateOrCreate($request->all());

        return response()->json(['success'=>'Product saved successfully.']);
    }

    public function edit($id)
    {
        $city = City::find($id);
        return response()->json($city);
    }

    public function destroy($id)
    {
        City::find($id)->delete();

        return response()->json(['success'=>'Product deleted successfully.']);
    }
}

    // public function store(StoreCityRequest $request)
    // {
    //     $request->validated();

    //     City::create($request->all());

    //     return redirect()->route('cities.index');
    // }

<?php

use App\Http\Controllers\AirlineController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FlightController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cities/all', [CityController::class,'getAll'])->name('cities.getAll');

Route::get('/airlines', [AirlineController::class,'get'])->name('airlines.get');
Route::get('/airlines/all', [AirlineController::class,'getAll'])->name('airlines.getAll');
Route::get('/airlines/{airline}', [AirlineController::class,'getAirline'])->name('airlines.getAirline');
Route::get('/airlines/create', [AirlineController::class,'create'])->name('airlines.create');
Route::post('/airlines', [AirlineController::class,'store'])->name('airlines.store');
Route::get('/airlines/{airline}/edit', [AirlineController::class,'edit'])->name('airlines.edit');
Route::put('/airlines/{airline}/update', [AirlineController::class,'update'])->name('airlines.update');
Route::delete('/airlines/{airline}/delete', [AirlineController::class,'destroy'])->name('airlines.destroy');

Route::get('/flights', [FlightController::class,'get'])->name('flights.get');
Route::delete('/flights/{flight}/delete', [FlightController::class,'destroy'])->name('flights.destroy');

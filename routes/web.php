<?php

use App\Http\Controllers\AirlineController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\FlightController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/cities', [CityController::class,'index'])->name('cities.index');
Route::get('/cities/create', [CityController::class,'create'])->name('cities.create');
Route::post('/cities', [CityController::class,'store'])->name('cities.store');
Route::get('/cities/{city}/edit', [CityController::class,'edit'])->name('cities.edit');
Route::post('/cities/{city}/update', [CityController::class,'update'])->name('cities.update');
Route::delete('/cities/{city}/delete', [CityController::class,'destroy'])->name('cities.destroy');

Route::get('/airlines', [AirlineController::class,'index'])->name('airlines.index');

Route::get('/flights', [FlightController::class,'index'])->name('flights.index');

<?php

use App\Http\Controllers\CityController;
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
Route::get('/cities', [CityController::class, 'index'])->name('cities.index');
Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
Route::resource('products-ajax-crud', CityController::class);

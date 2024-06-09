<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[StateController::class, 'index'] );

Route::post('/addCity',[CityController::class,'store']);
Route::get('/getCities',[CityController::class,'index']);
Route::get('/getCityByID',[CityController::class,'edit']);
Route::post('/updateCity',[CityController::class,'update']);

Route::post('/deleteCity',[CityController::class,'destroy']);

Route::get('/form',function(){
    return view('test');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
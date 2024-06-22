<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;

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

Route::get('/index', [StateController::class, 'index']);

Route::post('/addCity', [CityController::class, 'store']);
Route::get('/getCities', [CityController::class, 'index']);
Route::get('/getCityByID', [CityController::class, 'edit']);
Route::post('/updateCity', [CityController::class, 'update']);

Route::post('/deleteCity', [CityController::class, 'destroy']);

Route::get('/form', function () {
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('app');
});

Route::post('/api/employees', [EmployeeController::class, 'store']);
Route::get('/api/employees', [EmployeeController::class, 'index']);
Route::post('/api/employees/delete', [EmployeeController::class, 'deleteSelected']);
Route::get('/api/employees/export', [EmployeeController::class, 'export']);
Route::post('/api/send-email', [EmailController::class, 'sendEmail']);
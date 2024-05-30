<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\GovernorateController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\ReservationController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->group(function() {
Route::resource('buses', BusController::class);
Route::resource('drivers', DriverController::class);
Route::resource('governorates', GovernorateController::class);
Route::resource('trips', TripController::class);
Route::resource('reservations', ReservationController::class);
Route::get('/trips/{trip}/reservations', [TripController::class, 'showReservations'])->name('trips.reservations');
Route::get('/get-available-buses', [TripController::class,'getAvailableBuses'])->name('getAvailableBuses');

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

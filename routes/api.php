<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
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

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Authenticated Routes
Route::group(['middleware'=> ['auth:sanctum']], function () {
    Route::get('/trips', [TripController::class, 'getAllTripsFilteredByStartEndStations']);
    Route::post('/book', [TripController::class, 'bookTrip']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


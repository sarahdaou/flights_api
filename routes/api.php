<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PassengerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/passengers', [PassengerController::class, 'index']);

Route::get('/flights', [FlightController::class, 'index']);

Route::get('/flights/{flight}', [FlightController::class, 'show']);

Route::post('/flights', [FlightController::class, 'store']);

Route::put('/flights/{flight}', [FlightController::class, 'update']);

Route::delete('/flights/{flight}', [FlightController::class, 'destroy']);

Route::get('/passengers/{passenger}', [PassengerController::class, 'show']);

Route::post('/passengers', [PassengerController::class, 'store']);

Route::put('/passengers/{passenger}', [PassengerController::class, 'update']);

Route::delete('/passengers/{passenger}', [PassengerController::class, 'destroy']);
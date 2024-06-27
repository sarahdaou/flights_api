<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\AuthenticationController;

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


// Route::get('/flights', [FlightController::class, 'index']);
// Route::get('/flights/{flight}', [FlightController::class, 'show']);
// Route::post('/flights', [FlightController::class, 'store']);
// Route::put('/flights/{flight}', [FlightController::class, 'update']);
// Route::delete('/flights/{flight}', [FlightController::class, 'destroy']);

// Route::get('/passengers', [PassengerController::class, 'index']);
// Route::get('/passengers/{passenger}', [PassengerController::class, 'show']);
// Route::post('/passengers', [PassengerController::class, 'store']);
// Route::put('/passengers/{passenger}', [PassengerController::class, 'update']);
// Route::delete('/passengers/{passenger}', [PassengerController::class, 'destroy']);

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthenticationController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('passengers', PassengerController::class);
Route::apiResource('flights', PassengerController::class);

// GET           /users                      index   users.index
// POST          /users                      store   users.store
// GET           /users/{user}               show    users.show
// PUT|PATCH     /users/{user}               update  users.update
// DELETE        /users/{user}               destroy users.destroy
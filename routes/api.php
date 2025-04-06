<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FlightDataController;

Route::get('/data/metar/{icao}', [FlightDataController::class, 'getMetar']);
Route::get('/data/airport/{icao}', [FlightDataController::class, 'getAirport']);
Route::get('/debug', function () {
    return response()->json(['source' => 'api.php is working']);
});
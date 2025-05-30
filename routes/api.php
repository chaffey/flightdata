<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FlightDataController;
use App\Http\Controllers\Api\GithubPRAnalyzerController;

Route::get('/data/metar/{icao}', [FlightDataController::class, 'getMetar']);
Route::get('/data/airport/{icao}', [FlightDataController::class, 'getAirport']);
Route::get('/data/full/{icao}', [FlightDataController::class, 'getFullData']);
Route::get('/debug', function () {
    return response()->json(['source' => 'api.php is working']);
});
Route::post('/github/analyze-pr', [GithubPRAnalyzerController::class, 'receiveGithubWebhook']);
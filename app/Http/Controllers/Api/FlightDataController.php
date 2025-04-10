<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; 

class FlightDataController extends Controller
{
    public function getMetar($icao)
    {
        $cacheKey = "metar:$icao";

        $metar = Cache::remember($cacheKey, 3600, function () use ($icao) {
            $url = "https://aviationweather.gov/api/data/metar?ids={$icao}&format=json";
            $response = Http::get($url);
            return $response->json();
        });

        if(count($metar) == 0) {
            return response()->json(['error' => 'ICAO not found'], 404);
        }

        return response()->json($metar[0]);
    }

    public function getAirport($icao)
    {
        $cacheKey = "airport:$icao";

        $airport = Cache::remember($cacheKey, 60*60*24, function () use ($icao) {
            Log::debug("Fetching airport data from remote API for ICAO: $icao");
            $url = "https://aviationweather.gov/api/data/airport?ids={$icao}&format=json";
            $response = Http::get($url);
            return $response->json();
        });
        
        if(count($airport) == 0) {
            return response()->json(['error' => 'ICAO not found'], 404);
        }

        return response()->json($airport[0]);
    }

    public function getFullData($icao)
    {
        $airport = $this->getAirport($icao)->getOriginalContent();

        if (isset($airport['error'])) {
            return response()->json(['error' => 'ICAO not found'], 404);
        }

        $airport['metar'] = $this->getMetar($icao)->getOriginalContent();

        return response()->json($airport);
    }
}

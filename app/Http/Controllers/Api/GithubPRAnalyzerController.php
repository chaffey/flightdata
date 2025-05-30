<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log; 
use Illuminate\Http\Request;

class GithubPRAnalyzerController extends Controller
{
    public function receiveGithubWebhook(Request $request)
    {
        if(!$request->isJson()) {
            return response()->json(['error' => 'Invalid JSON payload'], 400);
        }

        try {
            $payload = $request->json();
            Log::info('Received GitHub webhook', $payload);
            return response()->json(['status' => 'success']);
        } catch(\InvalidArgumentException $e) {

            return response()->json(['error' => 'Invalid JSON payload'], 400);
        }
    }
}

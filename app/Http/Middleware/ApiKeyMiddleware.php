<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->header('X-API-KEY');

        if (!$key) {
            return response()->json(['error' => 'API key required'], 401);
        }

        $hash = hash('sha256', $key);

        $apiKey = ApiKey::where('key_hash', $hash)
            ->where('revoked', false)
            ->first();

        if (!$apiKey) {
            return response()->json(['error' => 'Invalid or revoked API key'], 401);
        }

        $request->attributes->set('apiKey', $apiKey);

        return $next($request);
    }
}

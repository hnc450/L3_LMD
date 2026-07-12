<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken() ?? $request->header('X-API-TOKEN');

        if (! $token) {
            return response()->json(['message' => 'Token API requis.'], 401);
        }

        $user = User::where('api_token', hash('sha256', $token))->first();

        if (! $user) {
            return response()->json(['message' => 'Token API invalide.'], 401);
        }

        auth()->login($user);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}

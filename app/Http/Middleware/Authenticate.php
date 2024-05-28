<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            Log::error('Token expired', ['exception' => $e]);
            return response()->json(['error' => 'Token expired'], 401);
        } catch (TokenInvalidException $e) {
            Log::error('Token invalid', ['exception' => $e]);
            return response()->json(['error' => 'Token invalid'], 401);
        } catch (JWTException $e) {
            Log::error('Token absent', ['exception' => $e]);
            return response()->json(['error' => 'Token absent'], 401);
        }

        if (!$user) {
            Log::error('Unauthorized access attempt');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Set the authenticated user in the request instance
        $request->attributes->add(['user' => $user]);

        return $next($request);
    }
}

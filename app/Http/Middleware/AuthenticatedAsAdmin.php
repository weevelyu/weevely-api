<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticatedAsAdmin
{
    public function handle(\Illuminate\Http\Request $request, \Closure $next)
    {
        $user = JWTAuth::user(JWTAuth::getToken());
        if ($user->role === "admin" && $user !== null)
            return response([
                'message' => 'Unauthenticated or not enough permissions.'
            ], 403);

        return $next($request);
    }
}

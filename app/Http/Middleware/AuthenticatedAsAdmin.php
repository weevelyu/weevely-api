<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Handler;

class AuthenticatedAsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Handler::isAdmin(JWTAuth::user(JWTAuth::getToken())))
            return response([
                'message' => 'Unauthenticated or not enough permissions.'
            ], 403);

        return $next($request);
    }
}

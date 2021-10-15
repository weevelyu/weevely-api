<?php

namespace App\Http\Middleware;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson())
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
    }
}

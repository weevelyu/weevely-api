<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SignInRequest;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{
    public function Register(RegisterRequest $request)
    {
        try {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < 10; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'image' => 'avatar' . rand(1, 10) . '_weevely_H265P.png',
                'password' => Hash::make($request->input('password')),
                'shareId' => $randomString
            ]);

            \App\Models\Calendar::create([
                'user_id' => $user->id,
                'title' => "My calendar",
                'main' => true,
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 400);
        }

        return response([
            'message' => 'User registered. Please log in',
            'user' => $user
        ]);
    }

    public function SignIn(SignInRequest $request)
    {
        try {
            $credentials = $request->only(['name', 'password']);
            if (JWTAuth::attempt($credentials)) {
                $user = JWTAuth::user();
                $token = JWTAuth::attempt($credentials);

                return response([
                    'message' => 'Signed in',
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'expires_in' => JWTAuth::factory()->getTTL() * 60,
                    'user' => $user
                ]);
            }

            return response([
                'message' => 'Incorrect password!'
            ], 400);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }
    }

    public function SignOut()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response(['message' => 'Successfully signed out']);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response(['error' => $e->getMessage()], 401);
        }
    }

    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            return response(['token' => $newToken]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response(['error' => $e->getMessage()], 401);
        }
    }

    public function me()
    {
        return JWTAuth::user(JWTAuth::getToken());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function ForgotPassword(\App\Http\Requests\ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        $token = \Illuminate\Support\Str::random(10);

        try {
            if ($existing = PasswordReset::where('email', $user->email)->first())
                $existing->update(['token' => $token]);
            else
                PasswordReset::create([
                    'email' => $user->email,
                    'token' => $token
                ]);

            $protocol = explode('//', $request->header('referer'))[0];
            $host = explode('//', $request->header('referer'))[1];
            $data = [
                'name' => $user->name,
                'role' => $user->role,
                'resetLink' => $protocol . '//' . $host  . 'reset-password/' . $token,
                'removeLink' => 'https://weevely.herokuapp.com/api/auth/reset-password/' . $token . '/remove'
            ];

            \Illuminate\Support\Facades\Mail::send('forgot', $data, function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Password reset confirmation.');
            });

            return response([
                'message' => 'Password reset confirmation sent to ' . $user->email . '!'
            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function ResetPassword(\App\Http\Requests\ResetPasswordRequest $request, string $token)
    {
        try {
            if (!$data = PasswordReset::where('token', $token)->first())
                return response([
                    'message' => 'Invalid token!'
                ], 400);

            /** @var User $user */
            if (!$user = User::where('email', $data->email)->first())
                return response([
                    'message' => 'User does not exist!'
                ], 404);

            $user->password = \Illuminate\Support\Facades\Hash::make($request->input('password'));
            $user->save();

            PasswordReset::where('email', $data->email)->delete();
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response([
            'message' => 'Password reset successful'
        ]);
    }

    public function RemoveRequestPassword(mixed $token)
    {
        if (!$data = PasswordReset::where('token', $token)->first())
            return response([
                'message' => "Password reset token was not found!"
            ]);

        $data->delete();
        return response([
            'message' => "Password reset token was successfully deleted. Thank you for your cooperation!"
        ]);
    }
}

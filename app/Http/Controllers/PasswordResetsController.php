<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordResets;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetsController extends Controller
{
    public function ForgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        $token = Str::random(10);

        try {
            if (PasswordResets::where('email', $user->email)->first())
                PasswordResets::where('email', $user->email)->update(['token' => $token]);
            else
                PasswordResets::create([
                    'email' => $user->email,
                    'token' => $token
                ]);

            $protocol = explode('//', $request->header('referer'))[0];
            $host = explode('//', $request->header('referer'))[1];
            $data = [
                'username' => $user->username,
                'name' => $user->name,
                'role' => $user->role,
                'resetLink' => $protocol . '//' . $host  . 'forgot-password/' . $token,
                'removeLink' => 'https://orbimind.herokuapp.com/api/auth/password-reset/' . $token . '/remove'
            ];
            Mail::send('forgot', $data, function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Password reset confirmation');
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

    public function ResetPassword(ResetPasswordRequest $request, mixed $token)
    {
        try {
            if (!$data = PasswordResets::where('token', $token)->first())
                return response([
                    'message' => 'Invalid token!'
                ], 400);

            /** @var User $user */
            if (!$user = User::where('email', $data->email)->first())
                return response([
                    'message' => 'User does not exist!'
                ], 404);

            $user->password = Hash::make($request->input('password'));
            $user->save();

            PasswordResets::where('email', $data->email)->delete();
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
        if (!$data = PasswordResets::where('token', $token)->first())
            return response([
                'message' => "Password reset token was not found!"
            ]);

        $data->delete();
        return response([
            'message' => "Password reset token was successfully deleted. Thank you for your cooperation!"
        ]);
    }
}

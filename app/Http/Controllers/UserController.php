<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UploadAvatarRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin')->only([
            'index',
            'store',
            'update',
            'destroy',
        ]);
        $this->user = JWTAuth::user(JWTAuth::getToken());
    }

    public function index()
    {
        return User::all();
    }

    public function store(RegisterRequest $request)
    {
        return User::create($request->all());
    }

    public function show(mixed $id)
    {
        if (!User::find($id))
            return response([
                'message' => 'User does not exist'
            ], 404);

        return response([
            "user" => User::find($id),
            "calendars" => User::find($id)->calendars
        ]);
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        if (!$data = User::find($id))
            return response([
                'message' => 'User does not exist'
            ], 404);
        $data->update($request->all());

        return $data;
    }

    public function destroy(int $id)
    {
        if (!User::find($id))
            return response([
                'message' => 'User does not exist'
            ], 404);

        return User::destroy($id);
    }

    public function uploadAvatar(UploadAvatarRequest $request)
    {
        if ($request->file('image')) {
            $user = User::find(JWTAuth::user(JWTAuth::getToken())->id);

            if (\Illuminate\Support\Facades\Storage::disk('s3')->exists('weevely/' . $user->image) && !str_contains($user->image, 'weevely_H265P'))
                \Illuminate\Support\Facades\Storage::disk('s3')->delete('weevely/' . $user->image);

            $user->update([
                'image' => $image = explode('/', $request->file('image')->storeAs('avatars', $user->id . $request->file('image')->getClientOriginalName(), 's3'))[1]
            ]);

            return response([
                "message" => "Your avatar was uploaded",
                "image" => $image
            ]);
        }
    }
}

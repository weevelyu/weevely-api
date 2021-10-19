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

    public function show(int|string $id)
    {
        if (is_numeric($id)) {
            if (!$user = User::find($id))
                return response([
                    'message' => 'User does not exist'
                ], 404);

            return $user;
        }
        if (!$user = User::where('name', $id)->first())
            return response([
                'message' => 'User does not exist'
            ], 404);

        return $user;
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        if (!$data = User::find($id))
            return response([
                'message' => 'User does not exist.'
            ], 404);

        return $data->update($request->all());
    }

    public function destroy(int $id)
    {
        if (!User::find($id))
            return response([
                'message' => 'User does not exist'
            ], 404);

        return User::destroy($id);
    }

    public function updateMe(UpdateUserRequest $request)
    {
        if (!$user = User::find($this->user->id))
            return response([
                'message' => 'User does not exist.'
            ], 404);

        $user->update($request->all());
        return response([
            "message" => "Successfully updated.",
            'cookie' => json_encode([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'image' => $user->image,
                'token' => $request->header('Authorization'),
                'ttl' => JWTAuth::factory()->getTTL() * 60
            ])
        ])->withCookie(cookie('user', json_encode([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->image,
            'token' => $request->header('Authorization')
        ]), JWTAuth::factory()->getTTL()));
    }

    public function uploadAvatar(UploadAvatarRequest $request)
    {
        if ($request->file('image')) {
            $user = User::find($this->user->id);
            $uimage = substr($user->image, 46);

            if (\Illuminate\Support\Facades\Storage::disk('s3')->exists('weevely/' . $uimage) && !str_contains($uimage, 'weevely_H265P'))
                \Illuminate\Support\Facades\Storage::disk('s3')->delete('weevely/' . $uimage);

            $user->update([
                'image' => $image = "https://d3djy7pad2souj.cloudfront.net/weevely/" . explode('/', $request->file('image')->storeAs('weevely', $user->id . $request->file('image')->getClientOriginalName(), 's3'))[1]
            ]);

            return response([
                "message" => "Your avatar was uploaded.",
                'cookie' => json_encode([
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'image' => $image,
                    'token' => $request->header('Authorization'),
                    'ttl' => JWTAuth::factory()->getTTL() * 60
                ])
            ], 201)->withCookie(cookie('user', json_encode([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'image' => $image,
                'token' => $request->header('Authorization')
            ]), JWTAuth::factory()->getTTL()));
        }
    }
}

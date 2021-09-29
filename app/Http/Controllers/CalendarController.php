<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Calendar;
use App\Models\Handler;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin')->only([
            'index',
            'store',
            'update',
        ]);
        $this->middleware('auth')->only([
            'destroy',
        ]);
        $this->user = JWTAuth::user(JWTAuth::getToken());
    }

    public function index()
    {
        return Calendar::all();
    }

    public function store(Request $request)
    {
        return Calendar::create($request->all());
    }

    public function show($id)
    {
        if (!$data = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist'
            ], 404);

        $data['events'] = Calendar::find($id)->events;
        return $data;
    }

    public function update(Request $request, $id)
    {
        if (!$data = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist'
            ], 404);
        $data->update($request->all());

        return $data;
    }

    public function destroy($id)
    {
        if (!$data = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist'
            ], 404);

        if (Handler::isAdmin($this->user))
            return Calendar::destroy($id);

        if ($data->user_id !== $this->user->id || $data->main)
            return response(["message" => "You can not delete this calendar."], 401);


        return Calendar::destroy($id) ? response(["message" => "Calendar successfuly deleted."], 201) : response(["message" => "You can not delete this calendar."], 401);
    }

    public function showCalendars()
    {
        return \App\Models\User::find($this->user->id)->calendars;
    }

    public function createCalendar(Request $request)
    {
        $data = [
            'user_id' => $this->user->id,
            'title' => $request->input('title') ? $request->input('title') : "New Calendar"
        ];

        return response([
            "message" => "Calendar successfuly created.",
            "calendar" => Calendar::create($data)
        ], 201);
    }
}

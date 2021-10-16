<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Calendar;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin')->only([
            'index',
            'store',
        ]);
        $this->middleware('auth')->only([
            'show',
            'update',
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

        $access = false;
        foreach ($data->users as $user)
            if ($user->id === $this->user->id)
                $access = true;
        if (!$access) return response([
            'message' => 'You do not have access to this calendar.'
        ], 403);

        $data['events'] = $data->events;
        return $data;
    }

    public function update(Request $request, $id)
    {
        if (!$data = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist'
            ], 404);

        $access = false;
        foreach ($data->users as $user)
            if ($user->id === $this->user->id && $user->calendar_user->is_owner)
                $access = true;
        if (!$access) return response([
            'message' => 'You do not have access to this calendar.'
        ], 403);

        $data->update($request->only(['title']));

        return $data;
    }

    public function destroy($id)
    {
        if (!$data = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        if ($this->user->role === "admin" && $this->user !== null) {
            $data->users()->detach();
            return Calendar::destroy($id);
        }

        $access = false;
        foreach ($data->users as $user)
            if ($user->id === $this->user->id && $user->calendar_user->is_owner)
                $access = true;
        if (!$access) return response([
            'message' => 'You do not have access to this calendar.'
        ], 403);

        if ($data->main)
            return response(["message" => "You can not delete this calendar."], 401);

        foreach ($data->users as $user)
            if ($user->id === $this->user->id && $user->calendar_user->is_owner) {
                $data->users()->detach();
                Calendar::destroy($id);
                return response(["message" => "Calendar successfuly deleted."], 201);
            }

        return response(["message" => "You can not delete this calendar."], 401);
    }

    public function showCalendars(string $type)
    {
        switch ($type) {
            case 'all':
                $data = \App\Models\User::find($this->user->id)->calendars;
                foreach ($data as $value) {
                    $calendar = Calendar::find($value->id);
                    $value["events"] = $calendar->events;
                    $value["users"] = $calendar->users;
                }
                return $data;
            case 'private':
                $data = \App\Models\User::with('owner')->find($this->user->id)->owner->where('hidden', false);
                foreach ($data as $value) {
                    $calendar = Calendar::find($value->id);
                    $value["events"] = $calendar->events;
                    $value["users"] = $calendar->users;
                }
                return $data;
            case 'shared':
                $data = \App\Models\User::with('shared')->find($this->user->id)->shared->where('hidden', false);
                foreach ($data as $value) {
                    $calendar = Calendar::find($value->id);
                    $value["events"] = $calendar->events;
                    $value["users"] = $calendar->users;
                }
                return $data;
            case 'hidden':
                $data = \App\Models\User::find($this->user->id)->calendars->where('hidden', true);
                $array = [];
                foreach ($data as $value) {
                    $calendar = Calendar::find($value->id);
                    $value["events"] = $calendar->events;
                    $value["users"] = $calendar->users;
                    array_push($array, $value);
                }
                return $array;
        }

        return response(['message' => 'Supported types are "all", "private", "shared", "hidden"'], 500);
    }

    public function createCalendar(\App\Http\Requests\CreateCalendarRequest $request)
    {
        $calendar = Calendar::create(['title' => $request->input('title') ? $request->input('title') : "New Calendar"]);
        Calendar::find($calendar->id)->users()->attach($this->user->id, ['is_owner' => true]);

        return response([
            "message" => "Calendar successfuly created.",
            "calendar" => $calendar,
        ], 201);
    }

    public function shareCalendar(\App\Http\Requests\ShareCalendarRequest $request, $id)
    {
        if (!$data = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        foreach ($data->users as $user)
            if ($user->id === $this->user->id && $user->calendar_user->is_owner) {
                $list = json_decode($request->input('users'));

                $new_users = [$this->user->id];
                foreach ($list as $obj) {
                    if (!$new_user = \App\Models\User::where('name', $obj)->orWhere('shareId', $obj)->first())
                        continue;
                    if ($new_user->id === $this->user->id)
                        continue;
                    array_push($new_users, $new_user->id);
                }
                $data->users()->sync($new_users);

                $data = Calendar::find($id);
                if (count($data->users) > 1 && !$data->shared)
                    $data->update(['shared' => true]);
                else $data->update(['shared' => false]);

                return response([
                    'message' => 'Calendar shared.'
                ], 201);
            }

        return response([
            'message' => 'You can not share this calendar.'
        ], 404);
    }

    public function hideCalendar($id)
    {
        if (!$data = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        foreach ($data->users as $user)
            if ($user->id === $this->user->id && $user->calendar_user->is_owner) {
                $data->update(['hidden' => !$data->hidden]);
                return response([
                    'message' => 'Calendar was hidden: ' . $data->hidden
                ], 201);
            }

        return response([
            'message' => 'You can not hide this calendar.'
        ], 404);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin')->only([
            'index',
            'store',
            'update',
            'destroy'
        ]);
        $this->user = \Tymon\JWTAuth\Facades\JWTAuth::user(\Tymon\JWTAuth\Facades\JWTAuth::getToken());
    }

    public function index()
    {
        return Event::all();
    }

    public function store(Request $request)
    {
        return Event::create($request->all());
    }

    public function show(int $id)
    {
        if (!$data = Event::find($id))
            return response([
                'message' => 'Event does not exist'
            ], 404);

        return $data;
    }

    public function update(Request $request, int $id)
    {
        if (!$data = Event::find($id))
            return response([
                'message' => 'Event does not exist'
            ], 404);
        $data->update($request->all());

        return $data;
    }

    public function destroy(int $id)
    {
        if (!Event::find($id))
            return response([
                'message' => 'Event does not exist'
            ], 404);

        return Event::destroy($id);
    }

    public function getCalendarEvents(int $id)
    {
        if (!$data = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        $access = false;
        foreach ($data->users as $user)
            if ($user->id === $this->user->id)
                $access = true;
        if (!$access) return response([
            'message' => 'You do not have access to this calendar.'
        ], 403);

        return $data->events;
    }

    public function createCalendarEvent(\App\Http\Requests\CreateEventRequest $request, int $calendar_id)
    {
        if (!$calendar = Calendar::find($calendar_id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        $access = false;
        foreach ($calendar->users as $user)
            if ($user->id === $this->user->id)
                $access = true;
        if (!$access) return response([
            'message' => 'You do not have access to this calendar.'
        ], 403);

        $data = [
            'calendar_id' => $calendar_id
        ];

        if ($request->exists('title'))
            $data['title'] = $request->input('title');

        if ($request->exists('content'))
            $data['content'] = $request->input('content');

        if ($request->exists('category'))
            $data['category'] = $request->input('category');

        if ($request->exists('target'))
            $data['target'] = Carbon::createFromFormat('Y-m-d', $request->input('target'))->addHour();
        else
            $data['target'] = Carbon::now()->addHour();

        return Event::create($data);
    }

    public function updateCalendarEvent(\App\Http\Requests\UpdateEventRequest $request, int $calendar_id, int $event_id)
    {
        if (!$calendar = Calendar::find($calendar_id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        $access = false;
        foreach ($calendar->users as $user)
            if ($user->id === $this->user->id)
                $access = true;
        if (!$access) return response([
            'message' => 'You do not have access to this calendar.'
        ], 403);

        $data = [];

        if ($request->exists('title'))
            $data['title'] = $request->input('title');

        if ($request->exists('content'))
            $data['content'] = $request->input('content');

        if ($request->exists('category'))
            $data['category'] = $request->input('category');

        if ($request->exists('target'))
            $data['target'] = Carbon::createFromFormat('Y-m-d H:i:s', $request->input('target'));

        Event::find($event_id)->update($data);
        return Event::find($event_id);
    }

    public function deleteCalendarEvent(int $calendar_id, int $event_id)
    {
        if (!$calendar = Calendar::find($calendar_id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        $access = false;
        foreach ($calendar->users as $user)
            if ($user->id === $this->user->id)
                $access = true;
        if (!$access) return response([
            'message' => 'You do not have access to this calendar.'
        ], 403);

        return Event::destroy($event_id);
    }

    public function parseHolidays(\App\Http\Requests\ParseHolidaysRequest $request, int $id)
    {
        if (!$calendar = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        $access = false;
        foreach ($calendar->users as $user)
            if ($user->id === $this->user->id && $user->calendar_user->is_owner)
                $access = true;
        if (!$access) return response([
            'message' => 'You do not have access to this calendar.'
        ], 403);

        $holiday_api = new \HolidayAPI\Client(['key' => env('HOLIDAYAPI_ACCESS_KEY')]);
        $holidays = $holiday_api->holidays([
            'country' => $request->input('country'),
            'year' => intval($request->input('year')),
        ]);

        $holidays = $holidays['holidays'];

        foreach ($holidays as $holiday => $value) {
            Event::create([
                'calendar_id' => $id,
                'title' => $value['name'],
                'content' => 'Today is ' . $value['name'] . ' observed!',
                'target' => Carbon::createFromFormat('Y-m-d', $value['date'])->setTime(10, 0)->addYear(),
                'system' => true
            ]);
        }
        return response([
            'message' => 'Holidays successfully added to calendar.',
            'calendar' => \App\Models\Calendar::find($id)
        ], 201);
    }
}

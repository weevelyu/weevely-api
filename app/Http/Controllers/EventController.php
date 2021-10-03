<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\Event;

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

    public function show($id)
    {
        if (!$data = Event::find($id))
            return response([
                'message' => 'Event does not exist'
            ], 404);

        return $data;
    }

    public function update(Request $request, $id)
    {
        if (!$data = Event::find($id))
            return response([
                'message' => 'Event does not exist'
            ], 404);
        $data->update($request->all());

        return $data;
    }

    public function destroy($id)
    {
        if (!Event::find($id))
            return response([
                'message' => 'Event does not exist'
            ], 404);

        return Event::destroy($id);
    }

    public function getCalendarEvents($id)
    {
        if (!$data = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);
        return $data->events;
    }

    public function createCalendarEvent(Request $request, $id)
    {
        if (!Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        $data = [
            'calendar_id' => $id
        ];

        if ($request->input('title'))
            $data['title'] = $request->input('title');

        if ($request->input('content'))
            $data['content'] = $request->input('content');

        if ($request->input('category'))
            $data['category'] = $request->input('category');

        if ($request->input('target'))
            $data['target'] = $request->input('target');
        else
            $data['target'] = \Carbon\Carbon::now()->addDay();

        if ($request->input('duration'))
            $data['duration'] = $request->input('duration');

        return Event::create($data);
    }

    public function updateCalendarEvent(Request $request, $id)
    {
        if (!$object = Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        if ($object->user_id !== $this->user->id)
            return response([
                'message' => 'You can not edit this event.'
            ], 404);

        $data = [];

        if ($request->input('title'))
            $data['title'] = $request->input('title');

        if ($request->input('content'))
            $data['content'] = $request->input('content');

        if ($request->input('category'))
            $data['category'] = $request->input('category');

        if ($request->input('target'))
            $data['target'] = $request->input('target');

        if ($request->input('duration'))
            $data['duration'] = $request->input('duration');

        return Event::find($id)->update($data);
    }

    public function deleteCalendarEvent($id)
    {
        if (!Calendar::find($id))
            return response([
                'message' => 'Calendar does not exist.'
            ], 404);

        return Event::destroy($id);
    }
}

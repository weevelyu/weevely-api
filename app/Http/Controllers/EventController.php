<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
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
}

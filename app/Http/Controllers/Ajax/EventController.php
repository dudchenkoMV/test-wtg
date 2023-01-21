<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventCollectionResource;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index()
    {
        return view('admin.events.index');
    }

    public function ajax(Request $request)
    {
        $events = Event::whereDate('start_at', '>=', $request->start)
            ->whereDate('end_at', '<', $request->end)
            ->where('user_id', '=', \Auth::id())
            ->get();

        return response()->json(EventResource::collection($events));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
        ]);

        $data['user_id'] = \Auth::id();

        $event = Event::create($data);

        return response()->json(new EventResource($event));
    }

    /**
     * @param Request $request
     * @param Event $event
     * @return JsonResponse
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date'],
        ]);

        $event->update($data);

        return response()->json(new EventResource($event));
    }

    /**
     * @param Event $event
     * @return void
     */
    public function destroy(Event $event)
    {
        $event->delete();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return response()->json($events); 
    }

    public function addEvent(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'organizer'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        $validated['created_by'] = $user->id;

        $event = Event::create($validated);

        return response()->json($event, 201);
    }

    public function updateEvent(Request $request, $id)
    {
        $user = Auth::user();
        $event = Event::findOrFail($id);

        if ($user->role === 'organizer' && $event->created_by !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!in_array($user->role, ['admin', 'organizer'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'date' => 'sometimes|required|date',
            'location' => 'sometimes|required|string|max:255',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    public function getEvent($id)
    {
        $event = Event::with('tickets', 'user')->findOrFail($id);
        return response()->json($event);
    }

    public function destroyEvent($id)
    {
        $user = Auth::user();
        $event = Event::findOrFail($id);

        if ($user->role === 'organizer' && $event->created_by !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!in_array($user->role, ['admin', 'organizer'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted']);
    }
}

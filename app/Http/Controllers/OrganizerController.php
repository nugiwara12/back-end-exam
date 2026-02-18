<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin sees all events
            $events = Event::with('tickets')->get();
        } else {
            // Organizer sees only their own events
            $events = Event::with('tickets')->where('created_by', $user->id)->get();
        }

        return response()->json($events);
    }

    public function displayOrgEvent($id)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin can view any event
            $event = Event::with('tickets')->findOrFail($id);
        } else {
            // Organizer can view only their own event
            $event = Event::with('tickets')
                ->where('id', $id)
                ->where('created_by', $user->id)
                ->firstOrFail();
        }

        return response()->json($event);
    }

    public function addOrgEvent(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        $validated['created_by'] = $user->id;

        $event = Event::create($validated);

        return response()->json([
            'message' => 'Event created successfully',
            'data' => $event
        ], 201);
    }

    public function updateOrgEvent(Request $request, $id)
    {
        $user = Auth::user();
        $event = Event::where('id', $id)->where('created_by', $user->id)->firstOrFail();

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'date' => 'sometimes|required|date',
            'location' => 'sometimes|required|string|max:255',
        ]);

        $event->update($validated);

        return response()->json($event);
    }

    public function destroyOrgEvent($id)
    {
        $user = Auth::user();
        $event = Event::where('id', $id)->where('created_by', $user->id)->firstOrFail();
        $event->delete();

        return response()->json(['message' => 'Event deleted']);
    }
}


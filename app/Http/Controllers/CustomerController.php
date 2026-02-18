<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function bookTicket(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $ticket = Ticket::findOrFail($validated['ticket_id']);

        // Optional: Check if enough tickets are available
        if ($ticket->quantity_available < $validated['quantity']) {
            return response()->json(['message' => 'Not enough tickets available'], 400);
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'ticket_id' => $ticket->id,
            'quantity' => $validated['quantity'],
        ]);

        // Reduce available tickets
        $ticket->quantity_available -= $validated['quantity'];
        $ticket->save();

        return response()->json([
            'message' => 'Ticket booked successfully',
            'data' => $booking
        ], 201);
    }

    public function myBookings()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin sees all bookings
            $bookings = Booking::with('ticket.event')->get();
        } else {
            // Customers see only their own bookings
            $bookings = Booking::with('ticket.event')
                ->where('user_id', $user->id)
                ->get();
        }

        return response()->json($bookings);
    }
}

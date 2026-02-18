<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Ticket;

class BookingController extends Controller
{
    public function addBooking(Request $request, $ticket_id)
    {
        try {

            $ticket = Ticket::find($ticket_id);

            if (!$ticket) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket not found'
                ], 404);
            }

            $booking = Booking::create([
                'ticket_id' => $ticket_id,
                'user_id' => $request->user_id,
                'quantity' => $request->quantity,
                'status' => 'booked'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully',
                'data' => $booking
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getBookings()
    {
        $bookings = Booking::all();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    public function getBooking($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    }

    public function cancelBooking($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking cancelled successfully'
        ]);
    }
}

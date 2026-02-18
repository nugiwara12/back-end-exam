<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function addTicket(Request $request, $event_id)
    {
        try {
            $ticket = Ticket::create([
                'event_id' => $event_id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ticket created successfully',
                'data' => $ticket
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getTickets()
    {
        $tickets = Ticket::all();

        return response()->json([
            'success' => true,
            'data' => $tickets
        ]);
    }

    public function getTicket($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $ticket
        ]);
    }

    public function updateTicket(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        $ticket->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket updated successfully',
            'data' => $ticket
        ]);
    }

    public function destroyTicket($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found'
            ], 404);
        }

        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket deleted successfully'
        ]);
    }
}

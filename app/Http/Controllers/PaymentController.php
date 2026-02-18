<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;

class PaymentController extends Controller
{
    public function addPayment($booking_id)
    {
        try {

            $booking = Booking::find($booking_id);

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ], 404);
            }

            $amount = $booking->quantity * $booking->ticket->price;

            $payment = Payment::create([
                'booking_id' => $booking_id,
                'amount' => $amount,
                'payment_method' => 'mock',
                'status' => 'paid'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
                'data' => $payment
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPayment($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $payment
        ]);
    }
}

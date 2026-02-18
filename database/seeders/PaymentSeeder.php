<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Booking;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            Payment::factory()->create([
                'booking_id' => $booking->id,
                'amount' => $booking->ticket->price * $booking->quantity,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Ticket;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role','customer')->get();
        $tickets = Ticket::all();

        // 20 bookings
        for ($i=0; $i<20; $i++) {
            Booking::factory()->create([
                'user_id' => $customers->random()->id,
                'ticket_id' => $tickets->random()->id,
            ]);
        }
    }
}

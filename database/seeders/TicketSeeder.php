<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Event;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::all();

        // 15 tickets in total (~3 per event)
        $ticketsPerEvent = 3;

        foreach ($events as $event) {
            Ticket::factory($ticketsPerEvent)->create([
                'event_id' => $event->id,
            ]);
        }
    }
}

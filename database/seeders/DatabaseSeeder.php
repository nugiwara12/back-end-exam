<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory(10)->create()->each(function($user){
            $user->events()->saveMany(Event::factory(2)->make());
        });

        Event::all()->each(function($event){
            $event->tickets()->saveMany(Ticket::factory(3)->make());
        });

        User::all()->each(function($user){
            $user->bookings()->saveMany(Booking::factory(2)->make());
        });

        Booking::all()->each(function($booking){
            Payment::factory()->create(['booking_id' => $booking->id]);
        });
    }
}

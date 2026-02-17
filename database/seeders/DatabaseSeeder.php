<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admins
        User::factory()->count(2)->admin()->create();

        // Create Organizers
        User::factory()->count(3)->organizer()->create();

        // Create Customers
        User::factory()->count(10)->create(); // default is customer
    }
}

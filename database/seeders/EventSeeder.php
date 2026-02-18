<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Get all organizers
        $organizers = User::where('role','organizer')->get();

        Event::factory(5)->make()->each(function ($event) use ($organizers) {
            $event->created_by = $organizers->random()->id;
            $event->save();
        });
    }
}

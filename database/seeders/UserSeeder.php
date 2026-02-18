<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 2 admins
        User::factory()->count(2)->create(['role'=>'admin']);

        // 3 organizers
        User::factory()->count(3)->create(['role'=>'organizer']);

        // 10 customers
        User::factory()->count(10)->create(['role'=>'customer']);
    }
}

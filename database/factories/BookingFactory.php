<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
use App\Models\User;
use App\Models\Ticket;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition() {
        return [
            'user_id' => null, 
            'ticket_id' => null,
            'quantity' => $this->faker->numberBetween(1,5),
            'status' => $this->faker->randomElement(['pending','confirmed','cancelled']),
        ];
    }
}


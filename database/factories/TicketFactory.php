<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ticket;
use App\Models\Event;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition() {
        return [
            'type' => $this->faker->randomElement(['VIP','Standard']),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'quantity' => $this->faker->numberBetween(50, 500),
            'event_id' => Event::factory(),
        ];
    }
}


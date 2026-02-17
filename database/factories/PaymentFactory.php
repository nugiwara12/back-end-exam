<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Booking;
use App\Models\Payment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition() {
        return [
            'booking_id' => Booking::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 2000),
            'status' => $this->faker->randomElement(['success','failed','refunded']),
        ];
    }
}


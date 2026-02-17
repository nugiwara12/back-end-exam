<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;  
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition() {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => $this->faker->dateTimeBetween('+1 days', '+1 year'),
            'location' => $this->faker->city,
            'created_by' => User::factory(),
        ];
    }
}


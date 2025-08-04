<?php
// database/factories/BookingFactory.php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'service_id' => Service::factory(),
            'booking_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function pending()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function confirmed()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    public function upcoming()
    {
        return $this->state(fn (array $attributes) => [
            'booking_date' => fake()->dateTimeBetween('+1 day', '+1 month'),
        ]);
    }
}
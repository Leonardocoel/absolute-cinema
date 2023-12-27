<?php

namespace Database\Factories;

use App\Models\Seat;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'user_id' => User::factory(),
            'schedule_id' => Schedule::factory(),
            'seat_id' => Seat::factory(),
            'price' => function ($attr) {
                $price = Ticket::find($attr['ticket_id'])->price;
                return $attr['is_half'] ? $price / 2 : $price;
            },
            'is_half' => fake()->boolean(),
        ];
    }
}

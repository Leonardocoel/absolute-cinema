<?php

namespace Database\Factories;

use App\Models\Seat;
use App\Models\Ticket;
use App\Models\UserAccount;
use App\Models\SessionSchedule;
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
            'user_account_id' => UserAccount::factory(),
            'session_schedule_id' => SessionSchedule::factory(),
            'seat_id' => Seat::factory(),
            'price' => fn ($attr) => Ticket::find($attr['ticket_id'])->price,
            'is_half' => fake()->boolean(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            "room_id" => Room::factory(),
            "seat_number" => fake()->numberBetween(1, 999),
            "seat_row" => fake()->randomLetter(),
            "is_accessible" => fn (array $attr) =>  Room::Find($attr['room_id'])->accessibility ? fake()->boolean() : false
        ];
    }
}

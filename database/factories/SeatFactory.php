<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Seat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    private static $seatRowCounter = 'A';
    private static $seatNumberCounter = 1;

    public function configure(): static
    {
        return $this->afterCreating(function (Seat $seat) {
            if (self::$seatRowCounter !== 'A') {
                self::$seatRowCounter = 'A';
                self::$seatNumberCounter = 1;
            };
        });
    }


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            "room_id" => Room::factory(),
            "seat_row" => function ($attr) {
                $maxSeatNumber = 20;

                if (self::$seatNumberCounter <= $maxSeatNumber) return self::$seatRowCounter;

                self::$seatNumberCounter = 1;
                return ++self::$seatRowCounter;
            },
            "seat_number" => function () {


                return self::$seatNumberCounter++;
            },
            "is_accessible" => fn (array $attr) =>  Room::Find($attr['room_id'])->accessibility ? fake()->boolean() : false
        ];
    }
}

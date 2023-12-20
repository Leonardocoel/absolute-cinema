<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
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
            "start_time" => fake()->dateTimeBetween('-3 months'),
            "end_time" => fn ($attr) => Carbon::parse($attr['start_time'])->addMinutes(120),
        ];
    }

    public function lastWeek(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => fake()->dateTimeBetween('-1 week')
        ]);
    }
}

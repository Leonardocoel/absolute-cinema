<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SessionSchedule>
 */
class SessionScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'session_id' => Session::factory(),
            'schedule_id' => Schedule::factory(),
            'movie_id' => Movie::factory()
        ];
    }
}

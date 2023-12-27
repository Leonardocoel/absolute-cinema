<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Movie;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    private static $latestSchedule = [];



    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "room_id" => Room::factory(),
            "session_id" => Session::factory(),
            "start_time" => fake()->time(),
            "day" => function ($attr) {
                ['session_id' => $session_id, 'room_id' => $room_id] = $attr;

                self::$latestSchedule[$session_id][$room_id] = isset(self::$latestSchedule[$session_id][$room_id])
                    ? Carbon::parse(self::$latestSchedule[$session_id][$room_id])->addDay()
                    : Session::find($session_id)->start_date;


                return self::$latestSchedule[$session_id][$room_id];
            },
            "movie_id" => Movie::factory()
        ];
    }
}

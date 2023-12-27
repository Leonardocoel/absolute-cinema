<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Cinema;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    private static $latestSession = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            "cinema_id" => Cinema::factory(),
            'start_date' => function ($attr) {
                $cinemaId = $attr['cinema_id'];

                self::$latestSession[$cinemaId] = isset(self::$latestSession[$cinemaId])
                    ? Carbon::parse(self::$latestSession[$cinemaId])->addWeek()
                    : Carbon::now()->subWeeks(4)->next(Carbon::THURSDAY);

                return self::$latestSession[$cinemaId];
            },
            'end_date' => fn ($attr) => Carbon::parse($attr['start_date'])->addDays(6),
            'is_visible' => fake()->boolean()
        ];
    }
}

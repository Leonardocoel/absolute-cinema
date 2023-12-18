<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Cinema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $startDate = fake()->date();
        $endDate = Carbon::parse($startDate)->addWeek();

        return [
            "cinema_id" => Cinema::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_visible' => fake()->boolean()
        ];
    }
}

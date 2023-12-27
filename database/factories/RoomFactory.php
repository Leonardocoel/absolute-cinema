<?php

namespace Database\Factories;

use App\Models\Cinema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cinema_id' => Cinema::Factory(),
            'name' => fake()->sentence(3),
            'capacity' => fake()->randomElement([100, 200, 300]),
            '3d_capable' => fake()->boolean(),
            'accessibility' => fake()->boolean(),
        ];
    }
}

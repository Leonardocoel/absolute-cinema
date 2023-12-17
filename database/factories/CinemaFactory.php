<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cinema>
 */
class CinemaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake($locale = 'pt_BR')->unique()->company(),
            "cnpj" => fake($locale = 'pt_BR')->unique()->cnpj(),
            "state" => fake($locale = 'pt_BR')->regionAbbr(),
            "city" => fake($locale = 'pt_BR')->city(),
            "address" => fake($locale = 'pt_BR')->streetName(),
            'email' => fake($locale = 'pt_BR')->unique()->safeEmail(),
            "phone" => fake($locale = 'pt_BR')->phone(),
        ];
    }
}

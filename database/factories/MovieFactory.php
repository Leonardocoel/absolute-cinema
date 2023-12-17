<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'synopsis' => fake()->paragraph(),
            'duration_minutes' => fake()->numberBetween(60, 180),
            'release_date' => fake()->date(),
            'genre' => fake()->randomElement(['ação', 'aventura', 'comédia']),
            'language' => fake()->randomElement(['Dublado', 'Nacional', 'Legendado']),
            'rating' => fake()->randomFloat(1, 1, 5),
            'availability' => fake()->boolean(),
            'image_url' => fake()->randomElement(['movies/mv1.jpg', 'movies/mv2.jpg']),
        ];
    }
}

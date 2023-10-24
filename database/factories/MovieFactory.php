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
            'title' => fake()->paragraph(),
            'director' => fake()->paragraph(),
            'image' => fake()->imageUrl(),
//            'genre' => fake()->paragraph(),
            'description' => fake()->paragraph(),
            'user_id' => 1,
            'status' => 1,
        ];
    }
}

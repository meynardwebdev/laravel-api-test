<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment' => fake()->realText,
            'rating' => rand(1, 5),
            'user_name' => fake()->userName,
            'product_id' => rand(1, 5),
            'created_at' => new \DateTime(),
            'updated_at' => null,
        ];
    }
}

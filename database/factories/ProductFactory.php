<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->word(),
            "category_id" => 1,
            "description" => fake()->sentence(),
            "price" => fake()->randomFloat(2, max: 2000.00),
            "sales" => fake()->numberBetween(0, 250),
            "likes" => fake()->numberBetween(0, 1000),
        ];
    }
}

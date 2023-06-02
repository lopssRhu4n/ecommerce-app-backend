<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 0, 10000),
            'client_id' => fake()->numberBetween(1, 10),
            'shipping' => fake()->randomFloat(2, 0, 100),
            'discount' => fake()->numberBetween(0, 50)
        ];
    }
}
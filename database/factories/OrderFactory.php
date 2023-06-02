<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->randomFloat(2, 0, 5000);
        $shipping = fake()->randomFloat(2, 0, 100);
        return [
            'amount' => $amount,
            'client_id' => fake()->numberBetween(1, 10),
            'client_address_id' => fake()->numberBetween(1, 10),
            'shipping' => $shipping,
            'total_amount' => $amount + $shipping,
            'deliver_status' => fake()->numberBetween(1, 3),
        ];
    }
}

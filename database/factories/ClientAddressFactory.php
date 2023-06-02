<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientAddress>
 */
class ClientAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cep' => fake()->numberBetween(10000000, 99999999),
            'city' => fake()->city(),
            'street' => fake()->streetName(),
            'number' => fake()->numberBetween(0, 2000),
            'complement' => fake()->word(),
            'client_id' => fake()->numberBetween(1, 10)
        ];
    }
}

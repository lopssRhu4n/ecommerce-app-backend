<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cpf' => fake()->numberBetween(10000000000, 99999999999),
            'birthdate' => fake()->date(),
            'phone' => fake()->phoneNumber(),
            'user_id' => 1
        ];
    }
}

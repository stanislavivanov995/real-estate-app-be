<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => random_int(1, 10000),
            'name' => fake()->company(),
            'description' => fake()->name,
            'rooms' => fake()->randomDigitNotNull,
            'price' => fake()->randomDigitNotNull,
            'currency' => fake()->currencyCode,
            'latitude' => fake()->creditCardNumber,
            'longtitude' => fake()->creditCardNumber,
            'category' => fake()->name,
        ];
    }
}

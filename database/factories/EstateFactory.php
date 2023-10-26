<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => random_int(1, 10000),
            'title' => fake()->company,
            'city' => fake()->city,
            'address' => fake()->streetAddress,
            'type' => fake()->realTextBetween(minNbChars:5, maxNbChars:20),
            'rooms' => fake()->randomDigitNotNull,
            'price' => fake()->randomDigitNotNull,
        ];
    }
}

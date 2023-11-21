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
            'description' => fake()->text,
            'rooms' => fake()->randomDigitNotNull,
            'price' => fake()->randomDigitNotNull,
            'currency' => fake()->randomElement(['BGN', 'USD', 'EUR']),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'category_id' => fake()->numberBetween(1, 5),
            'arrive_hour' => fake()->time,
            'leave_hour' => fake()->time
        ];
    }
}

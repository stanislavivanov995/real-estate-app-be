<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estate>
 */
class EstateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => random_int(1, 10000),
            'name' => fake()->company(),
            'description' => fake()->text,
            'rooms' => fake()->randomDigitNotNull,
            'price' => fake()->randomDigitNotNull,
            'currency' => fake()->currencyCode,
            'latitude' => fake()->creditCardNumber,
            'longtitude' => fake()->creditCardNumber,
            'category' => fake()->numberBetween(1, 4),
            'arrive_hour' => fake()->time,
            'leave_hour' => fake()->time
        ];
    }
}

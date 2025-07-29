<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'category' => $this->faker->randomElement(['Coffee', 'Pastry', 'Dessert']),
            'price' => $this->faker->numberBetween(10000, 50000),
            'stock' => $this->faker->numberBetween(10, 100),
            'image' => null,
        ];
    }
}
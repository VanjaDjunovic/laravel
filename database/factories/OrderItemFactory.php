<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'count' => $this->faker->numberBetween(1, 4),
            'unit_price' => $this->faker->randomFloat(2, 10, 40),
            'order_id' => $this->faker->numberBetween(1, 1000),
            'product_id' => $this->faker->numberBetween(1, 30)
        ];
    }
}

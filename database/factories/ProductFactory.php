<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->numberBetween(1, 1000000),
            'name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}

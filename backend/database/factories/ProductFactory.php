<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'user_id' => User::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numerify('####'),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 1, 9999),
            'stock' => fake()->numberBetween(0, 500),
            'is_active' => fake()->boolean(85),
        ];
    }
}

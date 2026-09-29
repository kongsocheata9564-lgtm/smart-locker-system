<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company().' Campus',
            'category' => fake()->randomElement(Location::CATEGORIES),
            'address' => fake()->streetAddress(),
            'price_per_hour' => fake()->randomFloat(2, 0, 10),
            'total_lockers' => 0,
            'free_lockers' => 0,
            'rating' => fake()->randomFloat(1, 3, 5),
        ];
    }
}

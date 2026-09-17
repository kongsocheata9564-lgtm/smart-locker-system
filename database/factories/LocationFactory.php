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
            'type' => fake()->randomElement(['building', 'library', 'shopping', 'sports', 'public']),
            'address' => fake()->streetAddress(),
            'description' => fake()->sentence(),
            'status' => 'active',
        ];
    }
}

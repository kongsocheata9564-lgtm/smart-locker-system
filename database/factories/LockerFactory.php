<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Locker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Locker>
 */
class LockerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->bothify('L-###'),
            'location_id' => Location::factory(),
            'type' => fake()->randomElement(['small', 'medium', 'large']),
            'status' => 'available',
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Locker;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'locker_id' => Locker::factory(),
            'started_at' => now(),
            'released_at' => null,
            'status' => 'active',
        ];
    }
}

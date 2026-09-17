<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'System Admin', 'email' => 'admin@example.com', 'role' => 'admin'],
            ['name' => 'Locker Staff', 'email' => 'staff@example.com', 'role' => 'staff'],
            ['name' => 'Normal User', 'email' => 'user@example.com', 'role' => 'user'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [...$user, 'password' => Hash::make('password')]
            );
        }
    }
}

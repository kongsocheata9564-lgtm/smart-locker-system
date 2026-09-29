<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@pse.ngo', 'role' => 'admin'],
            ['name' => 'Staff', 'email' => 'staff@gmail.com', 'role' => 'staff'],
            ['name' => 'User', 'email' => 'user@gmail.com', 'role' => 'user'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [...$user, 'password' => 'password', 'status' => 'active']
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['Admin',      'admin@pse.ngo', 'admin'],
            ['Test Staff', 'staff@example.com', 'staff'],
            ['Test User',  'user@example.com',  'user'],
        ];

        foreach ($accounts as [$name, $email, $role]) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name'     => $name,
                    'password' => env('SEED_PASSWORD', 'password123'), // hashed by the model cast
                    'role'     => $role,
                    'status'   => 'active',
                ]
            );
        }
    }
}
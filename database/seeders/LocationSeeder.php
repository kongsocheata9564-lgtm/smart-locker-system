<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // LocationSeeder::class,   <- remove this line
            LockerSeeder::class,        // see the warning below
        ]);
    }
}

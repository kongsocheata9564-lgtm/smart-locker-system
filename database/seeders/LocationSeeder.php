<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Main Building',
                'type' => 'building',
                'address' => 'Campus Block A',
                'description' => 'Primary student services building.',
                'status' => 'active',
            ],
            [
                'name' => 'Central Library',
                'type' => 'library',
                'address' => 'Library Road',
                'description' => 'Library entrance locker area.',
                'status' => 'active',
            ],
            [
                'name' => 'Sports Center',
                'type' => 'sports',
                'address' => 'Sports Complex',
                'description' => 'Locker area near indoor courts.',
                'status' => 'active',
            ],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(['name' => $location['name']], $location);
        }
    }
}

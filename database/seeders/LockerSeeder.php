<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Locker;
use Illuminate\Database\Seeder;

class LockerSeeder extends Seeder
{
    public function run(): void
    {
        Location::query()->each(function (Location $location): void {
            foreach (range(1, 5) as $number) {
                Locker::updateOrCreate(
                    [
                        'location_id' => $location->id,
                        'name' => sprintf(
                            '%s-%03d',
                            str($location->name)->replace(' ', '')->substr(0, 3)->upper(),
                            $number
                        ),
                    ],
                    [
                        'type' => match ($number % 3) {
                            1 => 'small',
                            2 => 'medium',
                            default => 'large',
                        },
                        'status' => 'available',
                    ]
                );
            }

            $location->update([
                'total_lockers' => $location->lockers()->count(),
                'free_lockers' => $location->lockers()->where('status', 'available')->count(),
            ]);
        });
    }
}

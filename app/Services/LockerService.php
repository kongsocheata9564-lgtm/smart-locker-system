<?php

namespace App\Services;

use App\Models\Locker;
use Illuminate\Database\Eloquent\Collection;

class LockerService
{
    /**
     * @return Collection<int, Locker>
     */
    public function availableByLocation(int $locationId): Collection
    {
        return Locker::query()
            ->where('location_id', $locationId)
            ->where('status', 'available')
            ->orderBy('locker_name')
            ->get();
    }

    /**
     * All lockers at a location, any status (used by the availability page).
     *
     * @return Collection<int, Locker>
     */
    public function allByLocation(int $locationId): Collection
    {
        return Locker::query()
            ->where('location_id', $locationId)
            ->orderBy('locker_name')
            ->get();
    }
}
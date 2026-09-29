<?php

namespace App\Services;

use App\Models\Locker;
use App\Models\LockerUsage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AssignmentService
{
    public function reserve(User $user, Locker $locker): LockerUsage
    {
        return DB::transaction(function () use ($user, $locker): LockerUsage {
            $locker = Locker::whereKey($locker->id)->lockForUpdate()->firstOrFail();
            abort_if($locker->status !== 'available', 409, 'Locker no longer available.');

            $usage = LockerUsage::create([
                'user_id'           => $user->id,
                'locker_id'         => $locker->id,
                'one_time_password' => Str::upper(Str::random(6)),
                'start_time'        => now(),
            ]);

            $locker->update(['status' => 'occupied']);

            return $usage;
        });
    }

    public function release(LockerUsage $usage): LockerUsage
    {
        return DB::transaction(function () use ($usage): LockerUsage {
            $usage = LockerUsage::whereKey($usage->id)->lockForUpdate()->firstOrFail();

            if ($usage->end_time === null) {
                $usage->update(['end_time' => now()]);
                $usage->locker()->update(['status' => 'available']);
            }

            return $usage->refresh();
        });
    }
}
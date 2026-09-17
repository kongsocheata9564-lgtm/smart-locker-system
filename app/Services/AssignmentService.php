<?php

namespace App\Services;

use App\Models\Assignment;
use App\Models\Locker;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AssignmentService
{
    public function reserve(User $user, Locker $locker): Assignment
    {
        return DB::transaction(function () use ($user, $locker): Assignment {
            $assignment = Assignment::create([
                'user_id' => $user->id,
                'locker_id' => $locker->id,
                'started_at' => now(),
                'status' => 'active',
            ]);

            $locker->update(['status' => 'occupied']);

            return $assignment;
        });
    }

    public function release(Assignment $assignment): Assignment
    {
        return DB::transaction(function () use ($assignment): Assignment {
            $assignment->update([
                'released_at' => now(),
                'status' => 'released',
            ]);

            $assignment->locker()->update(['status' => 'available']);

            return $assignment->refresh();
        });
    }
}

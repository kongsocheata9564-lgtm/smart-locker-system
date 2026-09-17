<?php

namespace App\Services;

use App\Models\AccessCode;
use App\Models\Assignment;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccessCodeService
{
    public function createForAssignment(Assignment $assignment, CarbonInterface $expiresAt): AccessCode
    {
        return AccessCode::create([
            'assignment_id' => $assignment->id,
            'code' => Hash::make(Str::random(12)),
            'expires_at' => $expiresAt,
            'status' => 'active',
        ]);
    }
}

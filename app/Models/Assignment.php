<?php

namespace App\Models;

use Database\Factories\AssignmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['user_id', 'locker_id', 'started_at', 'released_at', 'status'])]
class Assignment extends Model
{
    /** @use HasFactory<AssignmentFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function locker(): BelongsTo
    {
        return $this->belongsTo(Locker::class);
    }

    public function accessCodes(): HasMany
    {
        return $this->hasMany(AccessCode::class);
    }

    public function usageHistory(): HasOne
    {
        return $this->hasOne(UsageHistory::class);
    }

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'released_at' => 'datetime',
        ];
    }
}

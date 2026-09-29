<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Locker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location_id', 'price_per_hour', 'password', 'user_id', 'status', 'type',
    ];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function usageHistories(): HasMany
    {
        return $this->hasMany(UsageHistory::class);
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    public function usages(): HasMany
    {
        return $this->hasMany(UsageHistory::class);
    }

    // Keeps the numbers on the location cards ("14 free") in sync with real lockers
    public function syncLocationCounts(): void
    {
        $location = $this->location;

        if ($location) {
            $location->update([
                'total_lockers' => $location->lockers()->count(),
                'free_lockers' => $location->lockers()->where('status', 'available')->count(),
            ]);
        }
    }
}

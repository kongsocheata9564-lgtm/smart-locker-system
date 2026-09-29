<?php

namespace App\Models;

use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'name',
    'address',
    'type',
    'status',
    'map',
])]
class Location extends Model
{
    /** @use HasFactory<LocationFactory> */
    use HasFactory;

    public const CATEGORIES = [
        'Shopping Mall',
        'Library',
        'Sports Center',
        'Building',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::saving(function (Location $location) {
            if (empty($location->slug)) {
                $location->slug = Str::slug($location->name);
            }
        });
    }

    public function lockers(): HasMany
    {
        return $this->hasMany(Locker::class);
    }
}
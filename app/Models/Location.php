<?php

namespace App\Models;

use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

// every column that can be saved with Location::create() / ->update()
// (added slug, category, price_per_hour, total_lockers, free_lockers, rating, image;
//  removed the duplicate 'status')
#[Fillable([
    'name',
    'slug',
    'category',
    'address',
    'type',
    'status',
    'map',
    'price_per_hour',
    'total_lockers',
    'free_lockers',
    'rating',
    'image',
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

    // URLs use the slug instead of the id (e.g. /locations/abc-mall)
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        // safety net: if nobody set a slug, build one from the name
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
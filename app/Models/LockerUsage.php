<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LockerUsage extends Model
{
    protected $table = 'locker_usage';

    protected $fillable = ['locker_id', 'user_id', 'one_time_password', 'start_time', 'end_time'];

    protected function casts(): array
    {
        return ['start_time' => 'datetime', 'end_time' => 'datetime'];
    }

    public function user(): BelongsTo   { return $this->belongsTo(User::class); }
    public function locker(): BelongsTo { return $this->belongsTo(Locker::class); }

    public function getCodeAttribute()      { return $this->one_time_password; }
    public function getStartedAtAttribute() { return $this->start_time; }
    public function getExpiresAtAttribute() { return $this->start_time?->copy()->addHours(24); }
    public function getStatusAttribute()    { return $this->end_time ? 'released' : 'active'; }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    use HasFactory;

    // Laravel would guess "maintenances" anyway, this just makes it explicit
    protected $table = 'maintenances';

    // CHANGED: column names now match your database (see ERD)
    protected $fillable = [
        'locker_id',
        'reason',
        'reported_by_user_id',
        'solved_by_user_id',
        'status',
        'reported_at',
        'solved_at',
    ];

    // dates come back as Carbon objects, so ->format() works in the blade files
    protected $casts = [
        'reported_at' => 'datetime',
        'solved_at' => 'datetime',
    ];

    public function locker(): BelongsTo
    {
        return $this->belongsTo(Locker::class);
    }

    // the user who reported the problem
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by_user_id');
    }

    // the staff who solved it
    public function solver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solved_by_user_id');
    }
}
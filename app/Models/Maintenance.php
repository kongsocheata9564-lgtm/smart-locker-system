<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    protected $fillable = [
        'locker_id',
        'reason',
        'reportByUser_id',
        'solveByUser_id',
        'status',
        'report_at',
        'solve_at',
    ];

    protected function casts(): array
    {
        return [
            'report_at' => 'datetime',
            'solve_at' => 'datetime',
        ];
    }

    public function locker(): BelongsTo
    {
        return $this->belongsTo(Locker::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reportByUser_id');
    }

    public function solver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solveByUser_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagerPointsHistory extends Model
{
    use ForGameweek;

    protected $fillable = [
        'manager_id',
        'gameweek_id',
        'points',
        'position',
        'transfers_cost',
        'total_points',
        'total_position',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function getPaidTransfersCountAttribute(): int
    {
        return $this->transfers_cost / 4;
    }
}

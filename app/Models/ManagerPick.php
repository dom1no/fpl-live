<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManagerPick extends Pivot
{
    protected $fillable = [
        'manager_id',
        'player_id',
        'gameweek_id',
        'position',
        'is_captain',
        'is_vice_captain',
        'multiplier',
    ];

    public function gameweek(): BelongsTo
    {
        return $this->belongsTo(Gameweek::class);
    }
}

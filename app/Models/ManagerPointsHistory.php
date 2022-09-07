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
        'gameweek_points',
        'total_points',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }
}

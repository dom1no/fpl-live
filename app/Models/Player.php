<?php

namespace App\Models;

use App\Models\Enums\PlayerPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    protected $fillable = [
        'name',
        'full_name',
        'position',
        'price',
        'team_id',
        'fpl_id',
    ];

    protected $casts = [
        'position' => PlayerPosition::class,
        'price' => 'float',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}

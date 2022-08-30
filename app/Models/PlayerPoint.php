<?php

namespace App\Models;

use App\Models\Enums\PlayerPointAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerPoint extends Model
{
    use ForGameweek;

    protected $fillable = [
        'player_id',
        'gameweek_id',
        'action',
        'value',
        'points',
    ];

    protected $casts = [
        'action' => PlayerPointAction::class,
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagerPick extends Model
{
    protected $table = 'manager_pick';

    protected $fillable = [
        'manager_id',
        'player_id',
        'gameweek_id',
        'position',
        'is_captain',
        'is_vice_captain',
        'multiplier',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function gameweek(): BelongsTo
    {
        return $this->belongsTo(Gameweek::class);
    }

    public function scopeForGameweek(Builder $query, Gameweek $gameweek)
    {
        $query->where('gameweek_id', $gameweek->id);
    }
}

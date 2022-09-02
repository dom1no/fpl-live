<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagerPick extends Model
{
    use ForGameweek {
        scopeForGameweek as baseScopeForGameweek;
    }

    protected $table = 'manager_pick';

    protected $fillable = [
        'manager_id',
        'player_id',
        'gameweek_id',
        'is_captain',
        'is_vice_captain',
        'multiplier',
        'position',
        'points',
        'clean_points',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function scopeForGameweek(Builder $query, Gameweek $gameweek): void
    {
        if ($gameweek->is_next) {
            $gameweek = Gameweek::getCurrent();
        }

        $this->baseScopeForGameweek($query, $gameweek);
    }
}

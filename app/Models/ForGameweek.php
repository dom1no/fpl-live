<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ForGameweek
{
    public function gameweek(): BelongsTo
    {
        return $this->belongsTo(Gameweek::class);
    }

    public function scopeForGameweek(Builder $query, int|Gameweek $gameweek): void
    {
        $query->where('gameweek_id', is_int($gameweek) ? $gameweek : $gameweek->id);
    }

    public function scopeForCurrentGameweek(Builder $query): void
    {
        $query->where('gameweek_id', Gameweek::getCurrent()->id);
    }

    public function scopeWithoutNextGameweeks(Builder $query, int|Gameweek $gameweek): void
    {
        $query->where('gameweek_id', '<=', is_int($gameweek) ? $gameweek : $gameweek->id);
    }
}

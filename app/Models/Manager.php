<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Manager extends Model
{
    protected $fillable = [
        'name',
        'command_name',
        'total_points',
        'fpl_id',
    ];

    public function picks(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'manager_pick')->using(ManagerPick::class);
    }

    // TODO: eager loading
    public function getGameweekPicksQuery(Gameweek $gameweek): BelongsToMany
    {
        return $this->picks()->wherePivot('gameweek_id', $gameweek->id);
    }
}

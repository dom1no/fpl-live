<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerStats extends Model
{
    use ForGameweek;

    protected $table = 'player_stats';

    protected $fillable = [
        'player_id',
        'gameweek_id',
        'minutes',
        'goals_scored',
        'assists',
        'goals_conceded',
        'own_goals',
        'penalties_saved',
        'penalties_missed',
        'yellow_cards',
        'red_cards',
        'saves',
        'bonus',
        'bps',
        'influence',
        'creativity',
        'threat',
        'ict_index',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}

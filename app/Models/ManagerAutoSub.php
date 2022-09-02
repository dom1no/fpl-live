<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagerAutoSub extends Model
{
    use ForGameweek;

    protected $fillable = [
        'manager_id',
        'gameweek_id',
        'player_out_id',
        'player_in_id',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function playerOut(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function playerIn(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagerTransfer extends Model
{
    use ForGameweek;

    protected $fillable = [
        'manager_id',
        'gameweek_id',
        'player_out_id',
        'player_out_cost',
        'player_in_id',
        'player_in_cost',
        'is_free',
        'happened_at',
    ];

    protected $casts = [
        'is_free' => 'bool',
    ];

    protected $dates = [
        'happened_at',
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

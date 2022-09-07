<?php

namespace App\Models;

use App\Models\Enums\PlayerPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function managerPicks(): HasMany
    {
        return $this->hasMany(ManagerPick::class);
    }

    public function stats(): HasMany
    {
        return $this->hasMany(PlayerStats::class);
    }

    /** use with condition */
    public function gameweekStats(): HasOne
    {
        return $this->hasOne(PlayerStats::class);
    }

    public function points(): HasMany
    {
        return $this->hasMany(PlayerPoint::class);
    }
}

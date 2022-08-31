<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'fpl_id',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function fixtures(): BelongsToMany
    {
        return $this->belongsToMany(Fixture::class)->withPivot('is_home', 'score');
    }
}

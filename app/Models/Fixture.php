<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    protected $fillable = [
        'gameweek_id',
        'kickoff_time',
        'is_started',
        'is_finished',
        'is_finished_provisional',
        'minutes',
        'home_team_id',
        'away_team_id',
        'home_team_score',
        'away_team_score',
        'fpl_id',
    ];

    protected $dates = [
        'kickoff_time',
    ];

    public function gameweek(): BelongsTo
    {
        return $this->belongsTo(Gameweek::class);
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function isFeature(): bool
    {
        return $this->kickoff_time > now() && !$this->is_started;
    }

    public function isInProgress(): bool
    {
        return $this->is_started && !$this->is_finished && !$this->is_finished_provisional;
    }
}

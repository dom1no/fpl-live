<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fixture extends Model
{
    use ForGameweek;

    protected $fillable = [
        'gameweek_id',
        'kickoff_time',
        'is_started',
        'is_finished',
        'is_finished_provisional',
        'is_bonuses_added',
        'minutes',
        'fpl_id',
    ];

    protected $dates = [
        'kickoff_time',
    ];

    protected $casts = [
        'is_started' => 'bool',
        'is_finished' => 'bool',
        'is_finished_provisional' => 'bool',
        'is_bonuses_added' => 'bool',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)->withPivot('is_home', 'score');
    }

    public function isFeature(): bool
    {
        return $this->kickoff_time > now() && ! $this->is_started;
    }

    public function isInProgress(): bool
    {
        return $this->is_started && ! $this->isFinished();
    }

    public function isFinished(): bool
    {
        return $this->is_finished || $this->is_finished_provisional;
    }

    public function getHomeTeamAttribute(): ?Team
    {
        return $this->teams->firstWhere('pivot.is_home', true);
    }

    public function getAwayTeamAttribute(): ?Team
    {
        return $this->teams->firstWhere('pivot.is_home', false);
    }

    public function getScoreFormattedAttribute(): string
    {
        return $this->home_team->pivot->score . ':' . $this->away_team->pivot->score;
    }
}

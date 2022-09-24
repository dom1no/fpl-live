<?php

namespace App\View\Models\Fixture;

use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\ManagerPick;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

class ShowViewModel extends ViewModel
{
    public Fixture $fixture;
    public Gameweek $gameweek;
    public Collection $players;

    public function __construct(Fixture $fixture)
    {
        $this->fixture = $fixture;
        $this->gameweek = $fixture->gameweek;

        $this->players = $this->players();
    }

    private function players(): Collection
    {
        return Player::whereIn('team_id', $this->fixture->teams->pluck('id'))
            ->with([
                'gameweekStats' => fn ($q) => $q->forGameweek($this->gameweek),
                'points' => fn ($q) => $q->forGameweek($this->gameweek),
                'managerPicks' => fn ($q) => $q->forGameweek($this->gameweek),
                'managerPicks.manager',
            ])
            ->withSum(['points as points_sum' => fn ($q) => $q->forGameweek($this->gameweek)], 'points')
            ->get()
            ->sortByDesc('points_sum')
            ->keyBy('id')
            ->each(
                fn (Player $player) => $player->setRelation('team', $this->fixture->teams->get($player->team_id))
            );
    }

    public function homeTeam(): Team
    {
        return $this->fixture->home_team;
    }

    public function awayTeam(): Team
    {
        return $this->fixture->away_team;
    }

    public function managersPicks(): Collection
    {
        return $this->players->pluck('managerPicks')
            ->collapse()
            ->groupBy('manager_id')
            ->map(function (Collection $picks) {
                /** @phpstan-ignore-next-line */
                $picks->points_sum = $picks->sum('points');

                $picks->each(
                    fn (ManagerPick $pick) => $pick->setRelation('player', $this->players->get($pick->player_id))
                );

                return $picks;
            })
            ->sortByDesc('points_sum');
    }
}

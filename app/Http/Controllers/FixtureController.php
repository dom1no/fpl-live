<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\ManagerPick;
use App\Models\Player;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FixtureController extends Controller
{
    public function index(Request $request): View
    {
        $gameweek = $request->gameweek();

        $fixtures = Fixture::forGameweek($gameweek)
            ->with('teams')
            ->get();

        return view('fixtures.index', compact('gameweek', 'fixtures'));
    }

    public function show(Fixture $fixture): View
    {
        $players = Player::whereIn('team_id', $fixture->teams->pluck('id'))
            ->with([
                'gameweekStats' => fn ($q) => $q->forGameweek($fixture->gameweek),
                'points' => fn ($q) => $q->forGameweek($fixture->gameweek),
                'managerPicks' => fn ($q) => $q->forGameweek($fixture->gameweek),
                'managerPicks.manager',
            ])
            ->withSum(['points as points_sum' => fn ($q) => $q->forGameweek($fixture->gameweek)], 'points')
            ->get()
            ->sortByDesc('points_sum')
            ->keyBy('id');

        $players->each(function (Player $player) use ($fixture) {
            $player->setRelation('team', $fixture->teams->get($player->team_id));
        });

        $managersPicks = $players->pluck('managerPicks')
            ->collapse()
            ->groupBy('manager_id')
            ->map(function (Collection $picks) use ($players) {
                /** @phpstan-ignore-next-line */
                $picks->points_sum = $picks->sum('points');

                $picks->each(
                    fn (ManagerPick $pick) => $pick->setRelation('player', $players->get($pick->player_id))
                );

                return $picks;
            })
            ->sortByDesc('points_sum');

        return view('fixtures.show', compact('fixture', 'players', 'managersPicks'));
    }
}

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
                'team',
            ])
            ->withSum(['points as points_sum' => fn ($q) => $q->forGameweek($fixture->gameweek)], 'points')
            ->get()
            ->sortByDesc('points_sum')
            ->keyBy('id');

        $managersPicks = $players->pluck('managerPicks')
            ->collapse()
            ->groupBy('manager_id')
            ->map(function (Collection $picks) use ($fixture, $players) {
                $picks->points_sum = $fixture->isFeature() ? 0 : $picks->sum('points');

                $picks->each(
                    fn (ManagerPick $pick) => $pick->setRelation('player', $players->get($pick->player_id))
                );

                return $picks;
            })
            ->sortByDesc('points_sum');

        return view('fixtures.show', compact('fixture', 'players', 'managersPicks'));
    }
}

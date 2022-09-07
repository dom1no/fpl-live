<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

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

        $managersPicks = $players->pluck('managerPicks')
            ->collapse()
            ->groupBy('manager_id')
            ->map(function (Collection $picks) use ($fixture) {
                $picks->points_sum = $fixture->isFeature() ? 0 : $picks->sum('points');

                return $picks;
            })
            ->sortByDesc('points_sum');

        return view('fixtures.show', compact('fixture', 'players', 'managersPicks'));
    }
}

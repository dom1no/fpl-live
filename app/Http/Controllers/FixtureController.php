<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Player;
use App\Services\PlayerStatsService;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class FixtureController extends Controller
{
    public function index(): View
    {
        $gameweeks = Gameweek::with('fixtures', 'fixtures.homeTeam', 'fixtures.awayTeam')->get();

        return view('fixtures.index', compact('gameweeks'));
    }

    public function show(Fixture $fixture, PlayerStatsService $playerStatsService): View
    {
        $players = Player::whereIn('team_id', [$fixture->homeTeam->id, $fixture->awayTeam->id])
            ->with([
                'gameweekStats' => fn ($q) => $q->forGameweek($fixture->gameweek),
                'points' => fn ($q) => $q->forGameweek($fixture->gameweek),
                'managerPicks' => fn ($q) => $q->forGameweek($fixture->gameweek),
                'managerPicks.manager',
            ])
            ->withSum(['points as points_sum' => fn ($q) => $q->forGameweek($fixture->gameweek)], 'points')
            ->get()
            ->keyBy('id');

        $bpsTopPlayers = $playerStatsService->calculateBpsBonuses($players);

        $managersPicks = $players->pluck('managerPicks')
            ->collapse()
            ->groupBy('manager_id')
            ->map(function (Collection $picks) use ($fixture) {
                $picks->points_sum = $fixture->isFeature() ? 0 : $picks->sum('points');
                return $picks;
            });

        return view('fixtures.show', compact('fixture', 'players', 'bpsTopPlayers', 'managersPicks'));
    }
}

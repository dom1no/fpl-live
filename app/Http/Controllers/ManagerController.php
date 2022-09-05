<?php

namespace App\Http\Controllers;

use App\Models\Gameweek;
use App\Models\Manager;
use App\Models\ManagerPick;
use Illuminate\View\View;

// TODO: убрать дублирование
class ManagerController extends Controller
{
    public function index(): View
    {
        $gameweek = Gameweek::getCurrent();

        $managers = Manager::query()->with([
            'picks' => fn ($q) => $q->forGameweek($gameweek)->orderBy('position'),
            'picks.player.team',
            'picks.player.team.fixtures' => fn ($q) => $q->forGameweek($gameweek),
            'picks.player.team.fixtures.teams',
            'chips', // => fn ($q) => $q->forGameweek($gameweek),
        ])
            ->withCount([
                'transfers as paid_transfers_count' => fn ($q) => $q->forGameweek($gameweek)->where('is_free', false),
            ])
            ->withSum([
                'picks as gameweek_points' => fn ($q) => $q->forGameweek($gameweek),
            ], 'points')
            ->orderByDesc('total_points')
            ->get()
            ->keyBy('id');

        return view('managers.index', compact('managers', 'gameweek'));
    }

    public function show(Manager $manager): View
    {
        $gameweek = Gameweek::getCurrent();

        $manager
            ->load([
                'picks' => fn ($q) => $q->forGameweek($gameweek),
                'picks.player.team',
                'picks.player.team.fixtures' => fn ($q) => $q->forGameweek($gameweek),
                'picks.player.team.fixtures.teams', // TODO: оптимизировать, чтобы подгружать только соперника
                'autoSubs' => fn ($q) => $q->forGameweek($gameweek),
                'chips',
                'transfers' => fn ($q) => $q->orderByDesc('gameweek_id'),
                'transfers.gameweek',
            ])
            ->loadCount([
                'transfers as paid_transfers_count' => fn ($q) => $q->forGameweek($gameweek)->where('is_free', false),
            ])
            ->loadSum([
                'picks as gameweek_points' => fn ($q) => $q->forGameweek($gameweek),
            ], 'points');

        $mainPicks = $manager->picks->where('multiplier', '>', 0);

        $playedPicksCount = [
            'played' => $mainPicks->where(
                fn (ManagerPick $pick) => $pick->player->team->fixtures->first()?->isFinished(),
            )->count(),
            'playing' => $mainPicks->where(
                fn (ManagerPick $pick) => $pick->player->team->fixtures->first()?->isInProgress()
            )->count(),
        ];

        return view('managers.show', compact('manager', 'gameweek', 'playedPicksCount'));
    }
}

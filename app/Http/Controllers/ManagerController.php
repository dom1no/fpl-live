<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\ManagerPick;
use Illuminate\Http\Request;
use Illuminate\View\View;

// TODO: убрать дублирование
class ManagerController extends Controller
{
    public function index(Request $request): View
    {
        $gameweek = $request->gameweek();

        $managers = Manager::query()->with([
            'chips' => fn ($q) => $q->forGameweek($gameweek),
            'gameweekPointsHistory' => fn ($q) => $q->forGameweek($gameweek),
        ])
            ->withCount([
                'transfers as paid_transfers_count' => fn ($q) => $q->forGameweek($gameweek)->where('is_free', false),
            ])
            ->get()
            ->sortByDesc('gameweekPointsHistory.total_points')
            ->keyBy('id');

        return view('managers.index', compact('managers', 'gameweek'));
    }

    public function show(Request $request, Manager $manager): View
    {
        $gameweek = $request->gameweek();

        $manager
            ->load([
                'picks' => fn ($q) => $q->forGameweek($gameweek)->orderBy('position'),
                'picks.player.team',
                'picks.player.team.fixtures' => fn ($q) => $q->forGameweek($gameweek),
                'picks.player.team.fixtures.teams', // TODO: оптимизировать, чтобы подгружать только соперника
                'autoSubs' => fn ($q) => $q->forGameweek($gameweek),
                'chips' => fn ($q) => $q->withoutNextGameweeks($gameweek),
                'transfers' => fn ($q) => $q->withoutNextGameweeks($gameweek)->orderByDesc('gameweek_id'),
                'transfers.gameweek',
                'gameweekPointsHistory' => fn ($q) => $q->forGameweek($gameweek),
            ])
            ->loadCount([
                'transfers as paid_transfers_count' => fn ($q) => $q->forGameweek($gameweek)->where('is_free', false),
            ]);

        $managers = Manager::select('id')
            ->with([
                'gameweekPointsHistory' => fn ($q) => $q->forGameweek($gameweek),
            ])
            ->get();

        $managerPositions = [
            $gameweek->id => $managers
                    ->sortByDesc('gameweekPointsHistory.gameweek_points')
                    ->pluck('id')
                    ->search($manager->id) + 1,
            'total' => $managers
                    ->sortByDesc('gameweekPointsHistory.total_points')
                    ->pluck('id')
                    ->search($manager->id) + 1,
        ];

        $mainPicks = $manager->picks->where('multiplier', '>', 0);

        $playedPicksCount = [
            'played' => $mainPicks->where(
                fn (ManagerPick $pick) => $pick->player->team->fixtures->first()?->isFinished(),
            )->count(),
            'playing' => $mainPicks->where(
                fn (ManagerPick $pick) => $pick->player->team->fixtures->first()?->isInProgress()
            )->count(),
        ];

        return view('managers.show', compact('manager', 'gameweek', 'managerPositions', 'playedPicksCount'));
    }

    public function detailList(Request $request): View
    {
        $gameweek = $request->gameweek();

        $managers = Manager::query()->with([
            'picks' => fn ($q) => $q->forGameweek($gameweek)->orderBy('position'),
            'picks.player.team',
            'picks.player.team.fixtures' => fn ($q) => $q->forGameweek($gameweek),
            'picks.player.team.fixtures.teams',
            'chips' => fn ($q) => $q->forGameweek($gameweek),
            'gameweekPointsHistory' => fn ($q) => $q->forGameweek($gameweek),
        ])
            ->withCount([
                'transfers as paid_transfers_count' => fn ($q) => $q->forGameweek($gameweek)->where('is_free', false),
            ])
            ->get()
            ->sortByDesc('gameweekPointsHistory.total_points')
            ->keyBy('id');

        $playedPicksCountByManagers = $managers->map(function (Manager $manager) {
            $mainPicks = $manager->picks->where('multiplier', '>', 0);

            return [
                'played' => $mainPicks->where(
                    fn (ManagerPick $pick) => $pick->player->team->fixtures->first()?->isFinished(),
                )->count(),
                'playing' => $mainPicks->where(
                    fn (ManagerPick $pick) => $pick->player->team->fixtures->first()?->isInProgress()
                )->count(),
            ];
        });

        return view('managers.detail-list', compact('managers', 'gameweek', 'playedPicksCountByManagers'));
    }
}

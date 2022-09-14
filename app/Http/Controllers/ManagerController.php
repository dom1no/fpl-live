<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\ManagerPick;
use App\Models\ManagerTransfer;
use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

// TODO: убрать дублирование
class ManagerController extends Controller
{
    public function index(Request $request): View
    {
        $gameweek = $request->gameweek();

        $managers = Manager::query()
            ->with([
                'chips' => fn ($q) => $q->forGameweek($gameweek),
                'gameweekPointsHistory' => fn ($q) => $q->forGameweek($gameweek),
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
                'picks.player.points',
                'autoSubs' => fn ($q) => $q->forGameweek($gameweek),
                'chips' => fn ($q) => $q->withoutNextGameweeks($gameweek),
                'transfers' => fn ($q) => $q->withoutNextGameweeks($gameweek)->orderByDesc('gameweek_id'),
                'transfers.gameweek',
                'transfers.playerOut.points',
                'transfers.playerIn.points',
                'gameweekPointsHistory' => fn ($q) => $q->forGameweek($gameweek),
            ])
            ->loadSum('pointsHistory as total_transfers_cost', 'transfers_cost');

        $teams = Team::with('fixtures.teams', 'fixtures.gameweek')
            ->get()
            ->keyBy('id');

        $manager->picks->each(function (ManagerPick $pick) use ($teams) {
            $pick->player->setRelation('team', $teams->get($pick->player->team_id));
        });

        $manager->transfers->each(function (ManagerTransfer $transfer) use ($teams) {
            $transfer->playerOut->setRelation('team', $teams->get($transfer->playerOut->team_id));
            $transfer->playerIn->setRelation('team', $teams->get($transfer->playerIn->team_id));
        });

        $managers = Manager::select('id')
            ->with([
                'gameweekPointsHistory' => fn ($q) => $q->forGameweek($gameweek),
            ])
            ->get();

        $managerPositions = [
            $gameweek->id => $managers
                    ->sortByDesc('gameweekPointsHistory.points')
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

        $managers = Manager::query()
            ->with([
                'picks' => fn ($q) => $q->forGameweek($gameweek)->orderBy('position'),
                'picks.player.team',
                'picks.player.team.fixtures' => fn ($q) => $q->forGameweek($gameweek),
                'chips' => fn ($q) => $q->forGameweek($gameweek),
                'gameweekPointsHistory' => fn ($q) => $q->forGameweek($gameweek),
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

    public function transfers(Request $request): View
    {
        $gameweek = $request->gameweek();

        $managers = Manager::query()
            ->with([
                'transfers' => fn ($q) => $q->forGameweek($gameweek),
                'transfers.playerOut.points',
                'transfers.playerIn.points',
                'gameweekPointsHistory' => fn ($q) => $q->forGameweek($gameweek),
                'chips' => fn ($q) => $q->forGameweek($gameweek),
            ])
            ->get()
            ->sortByDesc('gameweekPointsHistory.total_points');

        $teams = Team::with('fixtures.teams', 'fixtures.gameweek')
            ->get()
            ->keyBy('id');

        $managers->each(function (Manager $manager) use ($teams) {
            $manager->transfers->each(function (ManagerTransfer $transfer) use ($teams) {
                $transfer->playerOut->setRelation('team', $teams->get($transfer->playerOut->team_id));
                $transfer->playerIn->setRelation('team', $teams->get($transfer->playerIn->team_id));
            });
        });

        return view('managers.transfers', compact('managers', 'gameweek'));
    }
}

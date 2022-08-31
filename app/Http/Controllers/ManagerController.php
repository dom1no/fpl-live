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
            'picks' => fn ($q) => $q->forCurrentGameweek(),
            'picks.player.team',
            'picks.player.team.fixtures' => fn ($q) => $q->forCurrentGameweek(),
            'picks.player.team.fixtures.teams', // TODO: оптимизировать, чтобы подгружать только соперника
        ])
            ->get()
            ->keyBy('id');

        $playedPicksByManagers = $managers->map(function (Manager $manager) {
            return $manager->picks
                ->where(
                    fn (ManagerPick $pick) => !$pick->player->team->fixtures->first()?->isFeature()
                );
        });

        return view('managers.index', compact('managers', 'gameweek', 'playedPicksByManagers'));
    }

    public function show(Manager $manager): View
    {
        $gameweek = Gameweek::getCurrent();

        $manager
            ->load([
                'picks' => fn ($q) => $q->forCurrentGameweek(),
                'picks.player.team',
                'picks.player.team.fixtures' => fn ($q) => $q->forCurrentGameweek(),
                'picks.player.team.fixtures.teams', // TODO: оптимизировать, чтобы подгружать только соперника
            ]);

        $playedPicksByManagers = collect([$manager->id => $manager])->map(function (Manager $manager) {
            return $manager->picks
                ->where(
                    fn (ManagerPick $pick) => !$pick->player->team->fixtures->first()?->isFeature()
                );
        });

        return view('managers.show', compact('manager', 'gameweek', 'playedPicksByManagers'));
    }
}

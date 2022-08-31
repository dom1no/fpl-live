<?php

namespace App\Http\Controllers;

use App\Models\Gameweek;
use App\Models\Manager;
use Illuminate\View\View;

class ManagerController extends Controller
{
    private const MY_MANAGER_ID = 3503081;

    public function index(): View
    {
        $gameweek = Gameweek::getCurrent();

        $managers = Manager::query()->with([
            'picks' => fn ($q) => $q->forCurrentGameweek(),
            'picks.player.team',
            'picks.player.team.fixtures' => fn ($q) => $q->forCurrentGameweek(),
            'picks.player.team.fixtures.teams', // TODO: оптимизировать, чтобы подгружать только соперника
        ])
            ->get();

        return view('managers.index', compact('managers', 'gameweek'));
    }

    public function my(): View
    {
        $gameweek = Gameweek::getCurrent();

        $manager = Manager::where('fpl_id', self::MY_MANAGER_ID)
            ->with([
                'picks' => fn ($q) => $q->forCurrentGameweek(),
                'picks.player.team',
                'picks.player.team.fixtures' => fn ($q) => $q->forCurrentGameweek(),
                'picks.player.team.fixtures.teams', // TODO: оптимизировать, чтобы подгружать только соперника
            ])
            ->first();

        return view('managers.my', compact('manager', 'gameweek'));
    }
}

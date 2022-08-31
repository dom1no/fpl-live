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
            ])
            ->first();

        return view('managers.my', compact('manager', 'gameweek'));
    }
}

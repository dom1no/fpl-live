<?php

namespace App\Http\Controllers;

use App\Models\Gameweek;
use App\Models\Manager;
use App\Models\Player;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $gameweek = Gameweek::getCurrent();

        $managers = Manager::query()->with([
            'picks' => fn ($q) => $q->forCurrentGameweek(),
            'picks.player.team',
        ])
            ->get();

        return view('teams', compact('managers', 'gameweek'));
    }
}

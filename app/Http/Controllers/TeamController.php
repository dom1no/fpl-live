<?php

namespace App\Http\Controllers;

use App\Models\Gameweek;
use App\Models\Manager;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function index(): View
    {
        $gameweek = Gameweek::getCurrent();

        $managers = Manager::query()->with([
            'picks' => fn ($q) => $q->forGameweek($gameweek),
            'picks.player.team',
        ])
            ->get();

        return view('teams', compact('managers'));
    }
}

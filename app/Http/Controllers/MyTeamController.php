<?php

namespace App\Http\Controllers;

use App\Models\Gameweek;
use App\Models\Manager;
use Illuminate\View\View;

class MyTeamController extends Controller
{
    private const MY_MANAGER_ID = 3503081;

    public function index(): View
    {
        $manager = Manager::where('fpl_id', self::MY_MANAGER_ID)->first();

        $picks = $manager->picks()
            ->forCurrentGameweek()
            ->with('player.team')
            ->get();

        return view('dashboard', compact('picks'));
    }
}

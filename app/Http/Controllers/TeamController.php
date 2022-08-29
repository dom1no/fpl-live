<?php

namespace App\Http\Controllers;

use App\Models\Gameweek;
use App\Models\Manager;

class TeamController extends Controller
{
    public function index()
    {
        $gameweek = Gameweek::getCurrent();

        $managers = Manager::query()->get();

        foreach ($managers as $manager) {
            $manager->setRelation(
                'picks', $manager->getGameweekPicksQuery($gameweek)->get()
            );
        }

        return response()->json($managers);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Gameweek;
use App\Models\Manager;
use Illuminate\Http\JsonResponse;

class MyTeamController extends Controller
{
    private const MY_MANAGER_ID = 3503081;

    public function index(): JsonResponse
    {
        $gameweek = Gameweek::getCurrent();
        $manager = Manager::where('fpl_id', self::MY_MANAGER_ID)->first();

        $players = $manager->getGameweekPicksQuery($gameweek)->get();

        return response()->json($players);
    }
}

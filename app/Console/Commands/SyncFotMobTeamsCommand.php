<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Services\FotMob\FotMobService;
use Illuminate\Console\Command;

class SyncFotMobTeamsCommand extends Command
{
    protected $signature = 'fot-mob:sync-teams';

    protected $description = 'Sync teams from fot mob';

    public function handle(FotMobService $fotMobService): void
    {
        // $teamsData = $fotMobService->getTeams();

        Team::each(function (Team $team) {
            $team->update([
                'fot_mob_id' => $this->mapFotMobId($team),
            ]);
        });
    }

    public function mapFotMobId(Team $team): ?int
    {
        return [
            1 => 9825,
            2 => 10252,
            3 => 8678,
            4 => 9937,
            5 => 10204,
            6 => 8455,
            7 => 9826,
            8 => 8668,
            9 => 9879,
            10 => 8197,
            11 => 8463,
            12 => 8650,
            13 => 8456,
            14 => 10260,
            15 => 10261,
            16 => 10203,
            17 => 8466,
            18 => 8586,
            19 => 8654,
            20 => 8602,
        ][$team->fpl_id] ?? null;
    }
}

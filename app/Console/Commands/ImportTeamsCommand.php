<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Services\FPL\FPLService;

class ImportTeamsCommand extends FPLImportCommand
{
    public function entityName(): string
    {
        return 'teams';
    }

    public function import(FPLService $FPLService): void
    {
        $data = $FPLService->getBootstrapStatic();
        $teamsData = $data['teams'];

        foreach ($teamsData as $teamData) {
            Team::updateOrCreate([
                'fpl_id' => $teamData['id'],
            ], [
                'name' => $teamData['name'],
                'short_name' => $teamData['short_name'],
            ]);

            $this->importedInc();
        }
    }
}

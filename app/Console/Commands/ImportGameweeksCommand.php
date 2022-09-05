<?php

namespace App\Console\Commands;

use App\Models\Gameweek;
use App\Services\FPL\FPLService;
use Carbon\Carbon;

class ImportGameweeksCommand extends FPLImportCommand
{
    public function entityName(): string
    {
        return 'gameweeks';
    }

    protected function import(FPLService $FPLService): void
    {
        $data = $FPLService->getBootstrapStatic();
        $gameweeksData = $data['events'];

        foreach ($gameweeksData as $playerData) {
            Gameweek::updateOrCreate([
                'fpl_id' => $playerData['id'],
            ], [
                'name' => $playerData['name'],
                'deadline_at' => Carbon::parse($playerData['deadline_time_epoch'])->addHours(3),
                'is_finished' => $playerData['finished'],
                'is_previous' => $playerData['is_previous'],
                'is_current' => $playerData['is_current'],
                'is_next' => $playerData['is_next'],
            ]);

            $this->importedInc();
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Manager;
use App\Services\FPL\FPLService;
use Illuminate\Console\Command;

class ImportManagersCommand extends Command
{
    private const LEAGUE_ID = 698751;

    protected $signature = 'import:managers';

    protected $description = 'Import managers from FPL API';

    public function handle(FPLService $FPLService): void
    {
        $this->info('Starting import managers...');

        $managers = $FPLService->getManagers(self::LEAGUE_ID);

        $importedCount = 0;
        foreach ($managers as $manager) {
            Manager::updateOrCreate([
                'fpl_id' => $manager['entry'],
            ], [
                'name' => $manager['player_name'],
                'command_name' => $manager['entry_name'],
                'total_points' => $manager['total'],
            ]);
            $importedCount++;
        }

        $this->info("Finished import managers. Imported {$importedCount} managers.");
    }
}

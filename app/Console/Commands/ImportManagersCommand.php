<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\HasImportedCount;
use App\Console\Commands\Traits\HasMeasure;
use App\Models\Manager;
use App\Services\FPL\FPLService;
use Illuminate\Console\Command;

class ImportManagersCommand extends Command
{
    use HasImportedCount;
    use HasMeasure;

    private const LEAGUE_ID = 698751;

    protected $signature = 'import:managers';

    protected $description = 'Import managers from FPL API';

    public function handle(FPLService $FPLService): void
    {
        $this->startMeasure();
        $this->info('Starting import managers...');

        $managers = $FPLService->getManagers(self::LEAGUE_ID);

        foreach ($managers as $manager) {
            Manager::updateOrCreate([
                'fpl_id' => $manager['entry'],
            ], [
                'name' => $manager['player_name'],
                'command_name' => $manager['entry_name'],
                'total_points' => $manager['total'],
                'telegram_username' => $this->mapManagerTelegram($manager['player_name']),
            ]);
            $this->importedInc();
        }

        $this->finishMeasure();
        $this->info("Finished import managers. {$this->importedCountText('managers')} {$this->durationText()}");
    }

    private function mapManagerTelegram(string $name): ?string
    {
        return match ($name) {
            'Maksim Kuprov' => '119785472',
            default => null,
        };
    }
}

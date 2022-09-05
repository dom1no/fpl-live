<?php

namespace App\Console\Commands;

use App\Models\Manager;
use App\Services\FPL\FPLService;

class ImportManagersCommand extends FPLImportCommand
{
    private const LEAGUE_ID = 698751;

    public function entityName(): string
    {
        return 'managers';
    }

    protected function import(FPLService $FPLService): void
    {
        $managers = $FPLService->getManagers(self::LEAGUE_ID);

        foreach ($managers as $manager) {
            Manager::updateOrCreate([
                'fpl_id' => $manager['entry'],
            ], [
                'name' => $manager['player_name'],
                'command_name' => $manager['entry_name'],
                // 'total_points' => $manager['total'], // вычисляем из пиков, потому что тут значение обновляется позже
                'telegram_username' => $this->mapManagerTelegram($manager['player_name']),
            ]);

            $this->importedInc();
        }
    }

    private function mapManagerTelegram(string $name): ?string
    {
        return match ($name) {
            'Maxim Kuprov' => '119785472',
            default => '119785472', //TODO
        };
    }
}

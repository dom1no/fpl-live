<?php

namespace App\Console\Commands;

use App\Models\Manager;
use App\Services\FPL\FPLService;
use Hash;

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
        $this->startProgressBar($managers->count());

        foreach ($managers as $manager) {
            Manager::updateOrCreate([
                'fpl_id' => $manager['entry'],
            ], [
                'name' => $manager['player_name'],
                'command_name' => $manager['entry_name'],
                // 'total_points' => $manager['total'], // вычисляем из пиков, потому что тут значение обновляется позже
                'telegram_username' => $this->mapManagerTelegram($manager['player_name']),
                'telegram_chat_id' => Manager::DEFAULT_TELEGRAM_CHAT_ID, // TODO

                'password' => Hash::make(Manager::DEFAULT_PASSWORD),
            ]);

            $this->importedInc();
            $this->advanceProgressBar();
        }
    }

    private function mapManagerTelegram(string $name): ?string
    {
        return match ($name) {
            'Maxim Kuprov' => 'Maksim_Kuprov',
            'Alex Yarm' => 'AlexeyYarm',
            'Denis Malkov' => 'mr_malkov',
            'Rail Fahrutdinov' => 'rail_ka1',
            'Nikita Karpasov' => 'Karpasoff',
            'Anton Kozlov' => 'whoooopss',
            'Daniel Yegorowski' => 'danegogo',
            'Ilya Dengin' => 'denginis',
            'Vlad Cheredov' => '',
            'Bulatelli Khamiev' => '',
            default => null,
        };
    }
}

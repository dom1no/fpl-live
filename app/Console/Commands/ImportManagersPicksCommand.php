<?php

namespace App\Console\Commands;

use App\Models\Gameweek;
use App\Models\Manager;
use App\Models\ManagerPick;
use App\Models\Player;
use App\Services\FPL\FPLService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ImportManagersPicksCommand extends Command
{
    protected $signature = 'import:managers-picks';

    protected $description = 'Import managers picks from FPL API';

    private Collection $players;

    public function handle(FPLService $FPLService): void
    {
        $this->info('Starting import managers picks...');

        $this->players = Player::pluck('id', 'fpl_id');

        Gameweek::finished()->each(function (Gameweek $gameweek) use ($FPLService) {
            Manager::each(function (Manager $manager) use ($FPLService, $gameweek) {
                $picks = $FPLService->getManagerPicksByGameweek($manager, $gameweek);
                $this->importManagerPicks($picks, $manager, $gameweek);
            });
        });

        $this->info('Finished import managers picks.');
    }

    private function importManagerPicks(Collection $picks, Manager $manager, Gameweek $gameweek): void
    {
        foreach ($picks as $pick) {
            ManagerPick::updateOrCreate([
                'manager_id' => $manager->id,
                'player_id' => $this->players->get($pick['element']),
                'gameweek_id' => $gameweek->id,
            ], [
                'is_captain' => $pick['is_captain'],
                'is_vice_captain' => $pick['is_vice_captain'],
                'multiplier' => $pick['multiplier'],
            ]);
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Gameweek;
use App\Models\Manager;
use App\Models\ManagerAutoSub;
use App\Models\ManagerPick;
use App\Models\Player;
use App\Services\FPL\FPLService;
use Illuminate\Support\Collection;

class ImportManagersPicksCommand extends FPLImportCommand
{
    private Collection $players;

    public function entityName(): string
    {
        return 'managers picks';
    }

    public function signatureArgs(): string
    {
        return '{--current}';
    }

    public function import(FPLService $FPLService): void
    {
        $this->players = Player::pluck('id', 'fpl_id');

        Gameweek::query()
            ->finishedOrCurrent()
            ->when($this->option('current'), fn ($q) => $q->where('is_current', true))
            ->each(function (Gameweek $gameweek) use ($FPLService) {
                Manager::each(function (Manager $manager) use ($FPLService, $gameweek) {
                    $data = $FPLService->getManagerGameweekInfo($manager, $gameweek);
                    $this->importManagerPicks($data['picks'], $manager, $gameweek);
                    $this->importManagerAutoSubs($data['automatic_subs'], $manager, $gameweek);
                });
            });
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
                'position' => $pick['position'],
            ]);

            $this->importedInc();
        }
    }

    private function importManagerAutoSubs(Collection $autoSubs, Manager $manager, Gameweek $gameweek): void
    {
        foreach ($autoSubs as $autoSub) {
            ManagerAutoSub::updateOrCreate([
                'manager_id' => $manager->id,
                'gameweek_id' => $gameweek->id,
                'player_out_id' => $this->players->get($autoSub['element_out']),
                'player_in_id' => $this->players->get($autoSub['element_in']),
            ]);
        }
    }
}

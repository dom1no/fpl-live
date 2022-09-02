<?php

namespace App\Console\Commands;

use App\Models\Enums\ChipType;
use App\Models\Gameweek;
use App\Models\Manager;
use App\Models\ManagerChip;
use App\Services\FPL\FPLService;
use Illuminate\Support\Collection;

class ImportManagersChipsCommand extends FPLImportCommand
{
    private Collection $gameweeks;

    public function entityName(): string
    {
        return 'managers chips';
    }

    public function import(FPLService $FPLService): void
    {
        $this->gameweeks = Gameweek::pluck('id', 'fpl_id');

        Manager::each(function (Manager $manager) use ($FPLService) {
            $chips = $FPLService->getManagerChips($manager);
            $this->importChips($chips, $manager);
        });
    }

    public function importChips(Collection $chips, Manager $manager): void
    {
        foreach ($chips as $chip) {
            ManagerChip::updateOrCreate([
                'manager_id' => $manager->id,
                'gameweek_id' => $this->gameweeks->get($chip['event']),
                'type' => ChipType::from($chip['name']),
            ]);

            $this->importedInc();
        }
    }
}

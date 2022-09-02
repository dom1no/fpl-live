<?php

namespace App\Console\Commands;

use App\Models\Gameweek;
use App\Models\Manager;
use App\Models\ManagerTransfer;
use App\Models\Player;
use App\Services\FPL\FPLService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ImportManagersTransfersCommand extends FPLImportCommand
{
    private Collection $gameweeks;
    private Collection $players;

    public function entityName(): string
    {
        return 'managers transfers';
    }

    public function import(FPLService $FPLService): void
    {
        $this->gameweeks = Gameweek::pluck('id', 'fpl_id');
        $this->players = Player::pluck('id', 'fpl_id');

        Manager::each(function (Manager $manager) use ($FPLService) {
            $transfers = $FPLService->getManagerTransfers($manager);
            $gameweeksStats = $FPLService->getManagerGameweekStats($manager);
            $this->importManagerTransfers($transfers, $gameweeksStats, $manager);
        });
    }

    private function importManagerTransfers(Collection $transfers, Collection $gameweeksStats, Manager $manager): void
    {
        foreach ($transfers->groupBy('event') as $eventFplId => $gameweekTransfers) {
            $gameweekTransfersCount = 0;

            $gameweekStats = $gameweeksStats->get($eventFplId);
            $paidTransfersCount = $gameweekStats['event_transfers_cost'] / 4;
            $freeTransfersCount = $gameweekTransfers->count() - $paidTransfersCount;

            $gameweekId = $this->gameweeks->get($eventFplId);

            foreach ($gameweekTransfers as $transfer) {
                $gameweekTransfersCount++;

                ManagerTransfer::updateOrCreate([
                    'manager_id' => $manager->id,
                    'player_out_id' => $this->players->get($transfer['element_out']),
                    'player_in_id' => $this->players->get($transfer['element_in']),
                    'gameweek_id' => $gameweekId,
                ], [
                    'player_out_cost' => $this->players->get($transfer['element_out_cost']),
                    'player_in_cost' => $this->players->get($transfer['element_in_cost']),
                    'is_free' => $gameweekTransfersCount <= $freeTransfersCount,
                    'happened_at' => Carbon::parse($transfer['time'])->addHours(3),
                ]);

                $this->importedInc();
            }
        }
    }
}

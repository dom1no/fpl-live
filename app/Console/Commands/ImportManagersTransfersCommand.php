<?php

namespace App\Console\Commands;

use App\Models\Gameweek;
use App\Models\Manager;
use App\Models\ManagerTransfer;
use App\Models\Player;
use App\Services\FPL\FPLService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ImportManagersTransfersCommand extends Command
{
    protected $signature = 'import:managers-transfers';

    protected $description = 'Import managers transfers from FPL API';

    private Collection $gameweeks;
    private Collection $players;

    public function handle(FPLService $FPLService): void
    {
        $this->info('Starting import managers transfers...');

        $this->gameweeks = Gameweek::pluck('id', 'fpl_id');
        $this->players = Player::pluck('id', 'fpl_id');

        Manager::each(function (Manager $manager) use ($FPLService) {
            $transfers = $FPLService->getManagerTransfers($manager);
            $gameweeksStats = $FPLService->getManagerGameweekStats($manager);
            $this->importManagerTransfers($transfers, $gameweeksStats, $manager);
        });

        $this->info('Finished import managers transfers.');
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
            }
        }
    }
}

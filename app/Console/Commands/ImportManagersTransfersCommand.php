<?php

namespace App\Console\Commands;

use App\Models\Gameweek;
use App\Models\Manager;
use App\Models\ManagerPointsHistory;
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

    protected function import(FPLService $FPLService): void
    {
        $this->gameweeks = Gameweek::pluck('id', 'fpl_id');
        $this->players = Player::pluck('id', 'fpl_id');

        Manager::query()
            ->tap(fn ($query) => $this->startProgressBar($query->count()))
            ->each(function (Manager $manager) use ($FPLService) {
                $transfers = $FPLService->getManagerTransfers($manager);
                $this->importManagerTransfers($transfers, $manager);

                $gameweeksStats = $FPLService->getManagerGameweeksStats($manager);
                $this->updateManagerTransfersCost($gameweeksStats, $manager);

                $this->advanceProgressBar();
            });
    }

    private function importManagerTransfers(Collection $transfers, Manager $manager): void
    {
        $existedTransfersIds = ManagerTransfer::where('manager_id', $manager->id)->pluck('id');
        $importedTransfersIds = [];

        foreach ($transfers->groupBy('event') as $eventFplId => $gameweekTransfers) {
            $gameweekTransfers = $this->collapseTransitiveTransfers($gameweekTransfers);

            $gameweekId = $this->gameweeks->get($eventFplId);

            foreach ($gameweekTransfers as $transfer) {
                $transfer = ManagerTransfer::updateOrCreate([
                    'manager_id' => $manager->id,
                    'player_out_id' => $this->players->get($transfer['element_out']),
                    'player_in_id' => $this->players->get($transfer['element_in']),
                    'gameweek_id' => $gameweekId,
                ], [
                    'player_out_cost' => $transfer['element_out_cost'] / 10,
                    'player_in_cost' => $transfer['element_in_cost'] / 10,
                    'happened_at' => Carbon::parse($transfer['time'])->addHours(3),
                ]);

                $importedTransfersIds[] = $transfer->id;

                $this->importedInc();
            }
        }

        ManagerTransfer::findMany($existedTransfersIds->diff($importedTransfersIds))->each->delete();
    }

    private function collapseTransitiveTransfers(Collection $transfers): Collection
    {
        $result = collect();

        $tt = collect($transfers);
        foreach ($transfers as $k => $transfer) {
            if (! $transfer = $transfers->get($k)) {
                continue;
            }

            $elementIn = $transfer['element_in'];
            $elementOut = $transfer['element_out'];

            if ($transfers->where('element_out', $elementIn)->isNotEmpty()) {
                $transitiveTransferKey = $transfers->where('element_out', $elementIn)->keys()->first();
                $transitiveTransfer = $transfers->get($transitiveTransferKey);
                $transfers->forget($k);
                if ($transitiveTransfer['element_in'] === $elementOut) {
                    $transfers->forget($transfers->where('element_out', $elementIn)->keys()->first());
                    continue;
                }

                $transitiveTransfer['element_out'] = $transfer['element_out'];
                $transitiveTransfer['element_out_cost'] = $transfer['element_out_cost'];
                $transfers->put($transitiveTransferKey, $transitiveTransfer);
            }
        }

        return $transfers;
    }

    private function updateManagerTransfersCost(Collection $gameweeksStats, Manager $manager): void
    {
        foreach ($gameweeksStats as $gameweekStats) {
            $managerPointsHistory = ManagerPointsHistory::firstOrNew([
                'manager_id' => $manager->id,
                'gameweek_id' => $this->gameweeks->get($gameweekStats['event']),
            ]);

            $managerPointsHistory->fill([
                'transfers_cost' => $gameweekStats['event_transfers_cost'],
            ])->save();
        }
    }
}

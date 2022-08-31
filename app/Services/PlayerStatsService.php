<?php

namespace App\Services;

use App\Models\Player;
use Illuminate\Support\Collection;

class PlayerStatsService
{
    public function calculateBpsBonuses(Collection $players): Collection
    {
        $bpsTopPlayers = $players->map(fn (Player $player) => [
            'bps' => $player->gameweekStats->bps ?? 0,
            'id' => $player->id,
        ])
            ->where('bps', '<>', 0)
            ->sortByDesc('bps');

        $bpsTopValues = $bpsTopPlayers->pluck('bps')->unique()->filter()->take(3)->values();

        return $this->getBonusesByPlayersIds($bpsTopPlayers, $bpsTopValues);
    }

    private function getBonusesByPlayersIds(Collection $bpsTopPlayers, Collection $bpsTopValues): Collection
    {
        $firstBps = $bpsTopValues->get(0);
        $first = $bpsTopPlayers->where('bps', $firstBps)->pluck('bps', 'id')->map(fn () => 3);

        if ($first->count() < 3) {
            $secondBps = $bpsTopValues->get(1);
            $second = $bpsTopPlayers->where('bps', $secondBps)->pluck('bps', 'id')->map(fn () => 2);

            if ($first->count() + $second->count() < 3) {
                $thirdBps = $bpsTopValues->get(2);
                $third = $bpsTopPlayers->where('bps', $thirdBps)->pluck('bps', 'id')->map(fn () => 1);
            }
        }

        return $first->union($second ?? collect())->union($third ?? collect());
    }
}

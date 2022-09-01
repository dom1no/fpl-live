<?php

namespace App\Observers;

use App\Models\Manager;
use App\Models\Player;
use App\Models\PlayerPoint;
use App\Notifications\PlayerActionNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

class PlayerPointObserver
{
    public function saved(PlayerPoint $playerPoint): void
    {
        $this->playerActionNotify($playerPoint);
    }

    private function playerActionNotify(PlayerPoint $playerPoint): void
    {
        if ($playerPoint->wasRecentlyCreated || $playerPoint->wasChanged('points')) {
            $managers = $this->getManagersHasPlayer($playerPoint->player);

            $diffPoints = $playerPoint->points - $playerPoint->getOriginal('points', 0);

            Notification::send(
                $managers,
                new PlayerActionNotification($playerPoint->player, $playerPoint->action, $diffPoints)
            );
        }
    }

    private function getManagersHasPlayer(Player $player): Collection
    {
        return Manager::whereHas('picks', function ($q) use ($player) {
            $q->where('player_id', $player->id)->forCurrentGameweek();
        })->get();
    }
}

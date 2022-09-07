<?php

namespace App\Observers;

use App\Models\Manager;
use App\Models\Player;
use App\Models\PlayerPoint;
use App\Notifications\PlayerActionNotification;
use App\Notifications\PlayerActionVarCancelledNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

class PlayerPointObserver
{
    public function saved(PlayerPoint $playerPoint): void
    {
        $this->playerActionNotify($playerPoint);
    }

    public function deleted(PlayerPoint $playerPoint): void
    {
        $this->playerActionNotify($playerPoint);
    }

    private function playerActionNotify(PlayerPoint $playerPoint): void
    {
        if ($playerPoint->wasRecentlyCreated || $playerPoint->wasChanged('points') || ! $playerPoint->exists) {
            $managers = $this->getManagersHasPlayer($playerPoint->player);

            if ($playerPoint->exists && $playerPoint->value - $playerPoint->getOriginal('value', 0) > 0) {
                $notification = new PlayerActionNotification($playerPoint);
            } else {
                $notification = new PlayerActionVarCancelledNotification($playerPoint);
            }

            Notification::send(
                // $managers,
                Manager::first(),
                $notification,
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

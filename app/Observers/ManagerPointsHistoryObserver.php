<?php

namespace App\Observers;

use App\Models\ManagerPointsHistory;

class ManagerPointsHistoryObserver
{
    public function saving(ManagerPointsHistory $managerPointsHistory): void
    {
        if ($managerPointsHistory->points != $managerPointsHistory->getOriginal('points')) {
            $managerPointsHistory->position = ManagerPointsHistory::where('gameweek_id', $managerPointsHistory->gameweek_id)
                    ->whereKeyNot($managerPointsHistory->id)
                    ->where('points', '>', $managerPointsHistory->points)
                    ->count() + 1;
        }

        if ($managerPointsHistory->total_points != $managerPointsHistory->getOriginal('total_points')) {
            $managerPointsHistory->total_position = ManagerPointsHistory::where('gameweek_id', $managerPointsHistory->gameweek_id)
                    ->whereKeyNot($managerPointsHistory->id)
                    ->where('total_points', '>', $managerPointsHistory->total_points)
                    ->count() + 1;
        }
    }
}

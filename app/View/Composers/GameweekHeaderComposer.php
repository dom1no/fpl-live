<?php

namespace App\View\Composers;

use App\Models\Gameweek;
use Illuminate\View\View;

class GameweekHeaderComposer
{
    public function compose(View $view): void
    {
        $currentGameweek = $view->gameweek ?? Gameweek::getCurrent();

        $gameweeks = Gameweek::query()->orderBy('id')->get();

        $previousId = $gameweeks->sortByDesc('id')->firstWhere('id', '<', $currentGameweek->id)->id ?? null;
        $nextId = $gameweeks->sortBy('id')->firstWhere('id', '>', $currentGameweek->id)->id ?? null;

        $gameweekUrl = function (?int $gameweekId) {
            return $gameweekId
                ? request()->fullUrlWithQuery(['gameweek' => $gameweekId])
                : null;
        };

        $view->with(compact('currentGameweek', 'gameweeks', 'previousId', 'nextId', 'gameweekUrl'));
    }
}

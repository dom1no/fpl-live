<?php

namespace App\View\Models\Fixture;

use App\Models\Fixture;
use App\Models\Gameweek;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

class IndexViewModel extends ViewModel
{
    public Gameweek $gameweek;

    public function __construct(Gameweek $gameweek)
    {
        $this->gameweek = $gameweek;
    }

    public function fixtures(): Collection
    {
        return Fixture::forGameweek($this->gameweek)
            ->with('teams')
            ->get();
    }
}

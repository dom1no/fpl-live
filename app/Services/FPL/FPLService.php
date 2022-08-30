<?php

namespace App\Services\FPL;

use App\Models\Gameweek;
use App\Models\Manager;
use App\Services\FPL\Requests\BootstrapStatic;
use App\Services\FPL\Requests\EventLive;
use App\Services\FPL\Requests\Fixtures;
use App\Services\FPL\Requests\LeagueInfo;
use App\Services\FPL\Requests\ManagerEventPicks;
use Illuminate\Support\Collection;

class FPLService
{
    private FPL $fpl;

    public function __construct(FPL $fpl)
    {
        $this->fpl = $fpl;
    }

    public function getBootstrapStatic(): array
    {
        return $this->fpl->send(new BootstrapStatic())->json();
    }

    public function getManagers(int $leagueId): Collection
    {
        $data = $this->fpl->send(new LeagueInfo($leagueId))->json();

        return collect($data['standings']['results']);
    }

    public function getManagerPicksByGameweek(Manager $manager, Gameweek $gameweek): Collection
    {
        $data = $this->fpl->send(new ManagerEventPicks($manager->fpl_id, $gameweek->fpl_id))->json();

        return collect($data['picks']);
    }

    public function getFixturesByGameweek(Gameweek $gameweek): Collection
    {
        $data = $this->fpl->send(new Fixtures($gameweek->fpl_id))->json();

        return collect($data);
    }

    public function getPlayersStatsByGameweek(Gameweek $gameweek): Collection
    {
        $data = $this->fpl->send(new EventLive($gameweek->fpl_id))->json();

        return collect($data['elements']);
    }
}

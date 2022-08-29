<?php

namespace App\Services\FPL;

use App\Services\FPL\Requests\BootstrapStatic;
use App\Services\FPL\Requests\LeagueInfo;
use App\Services\FPL\Requests\ManagerGWPicks;
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

    public function getManagerPicks(int $managerId, int $eventId): Collection
    {
        $data = $this->fpl->send(new ManagerGWPicks($managerId, $eventId))->json();

        return collect($data['picks']);
    }
}

<?php

namespace App\Services\FotMob;

use App\Models\Fixture;
use App\Models\Team;
use App\Services\FotMob\Requests\GetLeagueInfo;
use App\Services\FotMob\Requests\GetMatchDetails;
use App\Services\FotMob\Requests\GetTeam;
use Illuminate\Support\Collection;

class FotMobService
{
    private FotMob $fotMob;

    public function __construct(FotMob $fotMob)
    {
        $this->fotMob = $fotMob;
    }

    public function getTeams(): Collection
    {
        $response = $this->fotMob->send(new GetLeagueInfo())->json();

        return collect(
            $response['table'][0]['data']['table']['all']
        );
    }

    public function getMatches(): Collection
    {
        $response = $this->fotMob->send(new GetLeagueInfo())->json();

        return collect(
            $response['matches']
        );
    }

    public function getMatchStats(Fixture $fixture): Collection
    {
        $response = $this->fotMob->send(new GetMatchDetails($fixture->fot_mob_id))->json();

        return collect(
            $response['content']['stats']['stats']
        );
    }

    public function getTeam(Team $team): array
    {
        $response = $this->fotMob->send(new GetTeam($team->fot_mob_id))->json();

        return $response;
    }
}

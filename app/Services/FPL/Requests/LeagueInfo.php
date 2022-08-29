<?php

namespace App\Services\FPL\Requests;

use Sammyjo20\Saloon\Constants\Saloon;

class LeagueInfo extends Request
{
    protected ?string $method = Saloon::GET;

    private int $leagueId;

    public function __construct(int $leagueId)
    {
        $this->leagueId = $leagueId;
    }

    public function defineEndpoint(): string
    {
        return "leagues-classic/{$this->leagueId}/standings/";
    }
}

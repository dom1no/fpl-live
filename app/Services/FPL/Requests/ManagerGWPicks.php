<?php

namespace App\Services\FPL\Requests;

use Sammyjo20\Saloon\Constants\Saloon;

class ManagerGWPicks extends Request
{
    protected ?string $method = Saloon::GET;

    private int $managerId;
    private int $gw;

    public function __construct(int $managerId, int $gw)
    {
        $this->managerId = $managerId;
        $this->gw = $gw;
    }

    public function defineEndpoint(): string
    {
        return "entry/{$this->managerId}/event/{$this->gw}/picks/";
    }
}

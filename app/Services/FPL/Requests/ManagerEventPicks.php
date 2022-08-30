<?php

namespace App\Services\FPL\Requests;

use Sammyjo20\Saloon\Constants\Saloon;

class ManagerEventPicks extends Request
{
    protected ?string $method = Saloon::GET;

    private int $managerId;
    private int $eventId;

    public function __construct(int $managerId, int $eventId)
    {
        $this->managerId = $managerId;
        $this->eventId = $eventId;
    }

    public function defineEndpoint(): string
    {
        return "entry/{$this->managerId}/event/{$this->eventId}/picks/";
    }
}

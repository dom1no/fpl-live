<?php

namespace App\Services\FPL\Requests;

use Sammyjo20\Saloon\Constants\Saloon;

class EventLive extends Request
{
    protected ?string $method = Saloon::GET;

    private int $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    public function defineEndpoint(): string
    {
        return "event/{$this->eventId}/live/";
    }
}

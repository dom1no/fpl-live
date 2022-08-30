<?php

namespace App\Services\FPL\Requests;

use Sammyjo20\Saloon\Constants\Saloon;

class Fixtures extends Request
{
    protected ?string $method = Saloon::GET;

    private int $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    public function defineEndpoint(): string
    {
        return 'fixtures/';
    }

    public function defaultQuery(): array
    {
        return [
            'event' => $this->eventId,
        ];
    }
}

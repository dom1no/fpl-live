<?php

namespace App\Services\FotMob\Requests;

use Sammyjo20\Saloon\Constants\Saloon;

class GetMatchDetails extends Request
{
    protected ?string $method = Saloon::GET;

    public function __construct(protected int $matchId)
    {
    }

    public function defineEndpoint(): string
    {
        return '/api/matchDetails';
    }

    public function defaultQuery(): array
    {
        return [
            'matchId' => $this->matchId,
        ];
    }
}

<?php

namespace App\Services\FotMob\Requests;

use Sammyjo20\Saloon\Constants\Saloon;

class GetTeam extends Request
{
    protected ?string $method = Saloon::GET;

    public function __construct(protected int $teamId) {}

    public function defineEndpoint(): string
    {
        return '/api/teams';
    }

    public function defaultQuery(): array
    {
        return [
            'id' => $this->teamId,
        ];
    }
}

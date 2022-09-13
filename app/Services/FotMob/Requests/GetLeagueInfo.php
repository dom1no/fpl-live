<?php

namespace App\Services\FotMob\Requests;

use Sammyjo20\Saloon\Constants\Saloon;

class GetLeagueInfo extends Request
{
    protected ?string $method = Saloon::GET;

    public function defineEndpoint(): string
    {
        return '/api/leagues';
    }

    public function defaultQuery(): array
    {
        return [
            'id' => static::EPL_ID,
        ];
    }
}

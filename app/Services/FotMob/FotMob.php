<?php

namespace App\Services\FotMob;

use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Traits\Plugins\AlwaysThrowsOnErrors;

class FotMob extends SaloonConnector
{
    use AcceptsJson;
    use AlwaysThrowsOnErrors;

    public function defineBaseUrl(): string
    {
        return config('services.fot-mob.host');
    }

    public function defaultHeaders(): array
    {
        return [];
    }

    public function defaultConfig(): array
    {
        return [];
    }
}

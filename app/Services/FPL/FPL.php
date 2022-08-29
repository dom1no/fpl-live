<?php

namespace App\Services\FPL;

use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Traits\Plugins\AlwaysThrowsOnErrors;

class FPL extends SaloonConnector
{
    use AcceptsJson;
    use AlwaysThrowsOnErrors;

    public function defineBaseUrl(): string
    {
        return config('fpl.host') . 'api/';
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

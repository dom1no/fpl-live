<?php

namespace App\Services\FPL\Requests;

use Sammyjo20\Saloon\Constants\Saloon;

class BootstrapStatic extends Request
{
    protected ?string $method = Saloon::GET;

    public function defineEndpoint(): string
    {
        return 'bootstrap-static/';
    }
}

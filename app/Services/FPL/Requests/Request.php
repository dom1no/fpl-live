<?php

namespace App\Services\FPL\Requests;

use App\Services\FPL\FPL;
use Sammyjo20\Saloon\Http\SaloonRequest;

class Request extends SaloonRequest
{
    protected ?string $connector = FPL::class;
}

<?php

namespace App\Services\FotMob\Requests;

use App\Services\FotMob\FotMob;
use Sammyjo20\Saloon\Http\SaloonRequest;

class Request extends SaloonRequest
{
    protected const EPL_ID = 47;

    protected ?string $connector = FotMob::class;
}

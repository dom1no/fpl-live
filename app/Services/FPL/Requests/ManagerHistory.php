<?php

namespace App\Services\FPL\Requests;

use Sammyjo20\Saloon\Constants\Saloon;

class ManagerHistory extends Request
{
    protected ?string $method = Saloon::GET;

    private int $managerId;

    public function __construct(int $managerId)
    {
        $this->managerId = $managerId;
    }

    public function defineEndpoint(): string
    {
        return "entry/{$this->managerId}/history/";
    }
}

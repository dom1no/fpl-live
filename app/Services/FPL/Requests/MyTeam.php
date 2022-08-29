<?php

namespace App\Services\FPL\Requests;

use App\Services\FPL\Auth\Authenticator;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Interfaces\AuthenticatorInterface;

class MyTeam extends Request
{
    protected ?string $method = Saloon::GET;

    private int $managerId;

    public function __construct(int $managerId)
    {
        $this->managerId = $managerId;
    }

    public function defineEndpoint(): string
    {
        return "my-team/{$this->managerId}/";
    }

    public function defaultAuth(): ?AuthenticatorInterface
    {
        return new Authenticator();
    }
}

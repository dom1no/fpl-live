<?php

namespace App\Services\FPL\Auth;

use App\Services\UsersPL\UsersPlService;
use Cache;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Interfaces\AuthenticatorInterface;

class Authenticator implements AuthenticatorInterface
{
    public function set(SaloonRequest $request): void
    {
        $cookies = Cache::remember('fpl_login_cookies', now()->addMinutes(5), function () {
            $usersPlService = app(UsersPlService::class);

            return $usersPlService->loginCookies(config('fpl.login'), config('fpl.password'));
        });

        $request->mergeConfig([
            'cookies' => $cookies,
        ]);
    }
}

<?php

namespace App\Services\UsersPL;

use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Http;

class UsersPlService
{
    public function loginCookies(string $login, string $password): CookieJar
    {
        $response = Http::accept('*/*')
            ->withUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:97.0) Gecko/20100101 Firefox/97.0')
            ->withHeaders([
                'Cookie' => 'datadome=3r10TA.xsNf~GIlI-EvneYXfu8-tBa7TY-2DJ5rROY3W25coD.5bNRkfqk0MElfa~AJs35x_3BjRFNgpLwNHE1yn71y5LBTJu3MwRO0CohhrT50WEcMLMy3kJLaZ2qi;',
            ])
            ->asForm()
            ->post('https://users.premierleague.com/accounts/login/', [
                'login' => $login,
                'password' => $password,
                'redirect_uri' => 'https://fantasy.premierleague.com/',
                'app' => 'plfpl-web',
            ]);

        return $response->cookies();
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers {
        attemptLogin as parentAttemptLogin;
    }

    protected string $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(): string
    {
        return 'name';
    }

    public function validateLogin(Request $request): void
    {
        $request->validate([
            $this->username() => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request): void
    {
        $request->merge([
            'password' => Manager::DEFAULT_PASSWORD,
            'remember' => true,
        ]);

        $this->parentAttemptLogin($request);
    }
}

<?php

namespace App\Providers;

use App\Models\Gameweek;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Request::macro('gameweek', function () {
            $gameweekId = request()->gameweek;
            if (! $gameweekId) {
                return Gameweek::getCurrent();
            }

            return Gameweek::findOrFail($gameweekId);
        });

        LogViewer::auth(function ($request) {
            return $request->user() && $request->user()->isAdmin();
        });
    }
}

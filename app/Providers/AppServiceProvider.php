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
            /** @var Request $this */

            $gameweekId = $this->get('gameweek');

            if ($gameweekId instanceof Gameweek) {
                return $gameweekId;
            }

            $gameweek = $gameweekId
                ? Gameweek::findOrFail($gameweekId)
                : Gameweek::getCurrent();
            $this->merge(['gameweek' => $gameweek]);

            return $gameweek;
        });

        LogViewer::auth(function ($request) {
            return $request->user() && $request->user()->isAdmin();
        });
    }
}

<?php

namespace App\Providers;

use App\View\Composers\GameweekHeaderComposer;
use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('components.gameweek.header', GameweekHeaderComposer::class);
    }
}

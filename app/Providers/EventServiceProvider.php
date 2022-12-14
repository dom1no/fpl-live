<?php

namespace App\Providers;

use App\Models\Fixture;
use App\Models\ManagerPointsHistory;
use App\Models\PlayerPoint;
use App\Observers\FixtureObserver;
use App\Observers\ManagerPointsHistoryObserver;
use App\Observers\PlayerPointObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        PlayerPoint::observe(PlayerPointObserver::class);
        Fixture::observe(FixtureObserver::class);
        ManagerPointsHistory::observe(ManagerPointsHistoryObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

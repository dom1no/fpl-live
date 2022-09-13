<?php

namespace App\Console;

use App\Console\Commands\ImportFixturesCommand;
use App\Console\Commands\ImportGameweeksCommand;
use App\Console\Commands\ImportManagersChipsCommand;
use App\Console\Commands\ImportManagersPicksCommand;
use App\Console\Commands\ImportManagersTransfersCommand;
use App\Console\Commands\ImportPlayersCommand;
use App\Console\Commands\ImportPlayersStatsCommand;
use App\Console\Commands\SyncFotMobFixturesCommand;
use App\Console\Commands\UpcomingGameweekDeadlineNotifyCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(ImportFixturesCommand::class, ['--current'])->everyMinute();
        $schedule->command(ImportPlayersStatsCommand::class, ['--current'])->everyMinute();

        $schedule->command(ImportPlayersCommand::class)->hourly();

        $schedule->command(ImportGameweeksCommand::class)->hourly()
            ->after(function () {
                $this->call(ImportManagersPicksCommand::class);
                $this->call(ImportManagersTransfersCommand::class);
                $this->call(ImportManagersChipsCommand::class);
            });

        // $schedule->command(ImportTeamsCommand::class)->daily();
        // $schedule->command(ImportManagersCommand::class)->daily();

        $schedule->command(UpcomingGameweekDeadlineNotifyCommand::class)->everyThirtyMinutes();

        $schedule->command(SyncFotMobFixturesCommand::class)->daily();
        $schedule->command(SyncFotMobFixturesCommand::class, ['--stats', '--current'])->everyTenMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

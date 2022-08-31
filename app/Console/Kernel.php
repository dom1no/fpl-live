<?php

namespace App\Console;

use App\Console\Commands\ImportBaseDataCommand;
use App\Console\Commands\ImportFixturesCommand;
use App\Console\Commands\ImportManagersCommand;
use App\Console\Commands\ImportManagersPicksCommand;
use App\Console\Commands\ImportManagersTransfersCommand;
use App\Console\Commands\ImportPlayersStatsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(ImportFixturesCommand::class, ['--current'])->everyMinute();
        $schedule->command(ImportPlayersStatsCommand::class, ['--current'])->everyMinute();

        $schedule->command(ImportManagersCommand::class)->everyTenMinutes();

        $schedule->command(ImportBaseDataCommand::class)->after(function () {
            $this->call(ImportManagersPicksCommand::class);
            $this->call(ImportManagersTransfersCommand::class);
        });
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

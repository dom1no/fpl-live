<?php

namespace App\Console\Commands;

use App\Models\Gameweek;
use App\Models\Manager;
use App\Notifications\UpcomingGameweekDeadlineNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class UpcomingGameweekDeadlineNotifyCommand extends Command
{
    protected $signature = 'notify:upcoming-gameweek-deadline';

    protected $description = 'Notify about upcoming gameweek deadline';

    public function handle(): void
    {
        $upcomingGameweek = Gameweek::query()
            ->where('is_next', true)
            ->whereBetween('deadline_at', [
                now()->addDay()->toDateTimeString(),
                now()->addDay()->addMinutes(30)->toDateTimeString(),
            ])
            ->first();

        if (! $upcomingGameweek) {
            return;
        }

        Notification::send(Manager::all(), new UpcomingGameweekDeadlineNotification($upcomingGameweek));
    }
}

<?php

namespace App\Notifications;

use App\Models\Gameweek;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class UpcomingGameweekDeadlineNotification extends Notification
{
    private Gameweek $gameweek;

    public function __construct(Gameweek $gameweek)
    {
        $this->gameweek = $gameweek;
    }

    public function via(): array
    {
        return ['telegram'];
    }

    public function toTelegram(): TelegramMessage
    {
        return (new TelegramMessage())
            ->content("🔔 Дедлайн завтра в {$this->gameweek->deadline_at->format('H:i')} мск");
    }
}

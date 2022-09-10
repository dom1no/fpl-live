<?php

namespace App\Notifications;

use App\Models\Manager;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramWelcomeNotification extends Notification
{
    public function via(): array
    {
        return ['telegram'];
    }

    public function toTelegram(Manager $manager): TelegramMessage
    {
        return (new TelegramMessage())
            ->content("Привет, {$manager->name}!");
    }
}

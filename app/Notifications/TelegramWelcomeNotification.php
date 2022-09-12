<?php

namespace App\Notifications;

use App\Models\Manager;
use Illuminate\Notifications\Notification;
use MagicLink\Actions\LoginAction;
use MagicLink\MagicLink;
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
            ->content(implode("\n", [
                $this->getHiText($manager),
                $this->getInviteLinkText($manager),
            ]));
    }

    private function getHiText(Manager $manager): string
    {
        return "Привет, {$manager->name}!";
    }

    private function getInviteLinkText(Manager $manager): string
    {
        $action = new LoginAction($manager);

        $urlToAutoLogin = MagicLink::create($action)->url;

        return "Твой профиль готов: [FPL]({$urlToAutoLogin})";
    }
}

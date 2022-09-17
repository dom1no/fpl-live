<?php

namespace App\Notifications;

use App\Models\Fixture;
use App\Models\Manager;
use App\Models\ManagerPick;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class FixtureStartedNotification extends Notification
{
    private Fixture $fixture;

    public function __construct(Fixture $fixture)
    {
        $this->fixture = $fixture;
    }

    public function via(): array
    {
        return ['telegram'];
    }

    public function toTelegram(Manager $manager): TelegramMessage
    {
        return TelegramMessage::create()
            ->content(implode("\n", [
                $this->getTitleText(),
                $this->getManagerPicksText($manager),

                '',
                $manager->telegram_chat_id === Manager::DEFAULT_TELEGRAM_CHAT_ID ? "`{$manager->name}`" : '', // TODO: удалить, после выката для всех
            ]));
    }

    private function getTitleText(): string
    {
        $fixtureLink = route('fixtures.show', $this->fixture);

        return "🏃‍♂️ Матч [{$this->fixture->home_team->name} - {$this->fixture->away_team->name}]({$fixtureLink}) начался!";
    }

    private function getManagerPicksText(Manager $manager): string
    {
        return $manager->picks
            ->sortByDesc('player.price')
            ->map(function (ManagerPick $pick) {
                $isCaptain = $pick->is_captain;

                return "{$pick->player->name} ({$pick->player->team->name})" . ($isCaptain ? '©️' : '');
            })
            ->implode("\n");
    }
}

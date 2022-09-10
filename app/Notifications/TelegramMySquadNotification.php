<?php

namespace App\Notifications;

use App\Models\Gameweek;
use App\Models\Manager;
use App\Models\ManagerPick;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramMySquadNotification extends Notification
{
    public function via(): array
    {
        return ['telegram'];
    }

    public function toTelegram(Manager $manager): TelegramMessage
    {
        return (new TelegramMessage())
            ->content(implode("\n", [
                $this->getManagerText($manager),
                $this->getGameweekText(),
                $this->getPicksText($manager),
            ]));
    }

    private function getManagerText(Manager $manager): string
    {
        $managerUrl = route('home');

        return "[{$manager->name}]({$managerUrl})";
    }

    private function getGameweekText(): string
    {
        $gameweek = Gameweek::getCurrent();

        return "*{$gameweek->name}*";
    }

    private function getPicksText(Manager $manager): string
    {
        $picks = $manager->picks()
            ->forGameweek(Gameweek::getCurrent())
            ->with('player.team')
            ->orderBy('position')
            ->get();

        $message = $picks->map(function (ManagerPick $pick) {
            $message = '';

            if ($pick->position === 12) {
                $message = "\n_Запас_: \n";
            }

            return $message . $this->getPickText($pick) . "\n";
        })
             ->implode('');

        $message .= $this->getTotalPointsText($picks);

        return $message;
    }

    private function getPickText(ManagerPick $pick): string
    {
        $pickName = $pick->player->name . ($pick->is_captain ? '©️' : '');

        return "{$pickName} - " . ($pick->multiplier == 0 ? $pick->clean_points : $pick->points);
    }

    private function getTotalPointsText(Collection $picks): string
    {
        return "\n*Всего: {$picks->sum('points')}*";
    }
}

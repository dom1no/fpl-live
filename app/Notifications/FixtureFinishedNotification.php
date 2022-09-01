<?php

namespace App\Notifications;

use App\Models\Fixture;
use App\Models\Manager;
use App\Models\ManagerPick;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class FixtureFinishedNotification extends Notification
{
    private Fixture $fixture;
    private Manager $manager;

    public function __construct(Fixture $fixture, Manager $manager)
    {
        $this->fixture = $fixture;
        $this->manager = $manager;
    }

    public function via(): array
    {
        return ['telegram'];
    }

    public function toTelegram(): TelegramMessage
    {
        return TelegramMessage::create()
            ->content(implode("\n", [
                $this->getWinText(),
                $this->getScoreText(),
                "\n",
                $this->getManagerPointsText(),
                $this->getManagerTotalPointsText(),
            ]));
    }

    private function getWinText(): string
    {
        if ($this->fixture->home_team->pivot->score == $this->fixture->away_team->pivot->score) {
            return 'Ничья!';
        }

        if ($this->fixture->home_team->pivot->score == $this->fixture->away_team->pivot->score) {
            $winner = $this->fixture->home_team;
        } else {
            $winner = $this->fixture->away_team;
        }

        return "Победа {$winner->name}!";
    }

    private function getScoreText(): string
    {
        $fixture = $this->fixture;
        $fixtureUrl = route('fixtures.show', $fixture);

        return "[{$fixture->home_team->name} {$fixture->score_formatted} {$fixture->away_team->name}]({$fixtureUrl})";
    }

    private function getManagerPointsText(): string
    {
        return $this->manager->picks->map(function (ManagerPick $pick) {
            $isCaptain = $pick->is_captain;

            return "{$pick->player->name} ({$pick->player->team->name}): {$pick->points} " . ($isCaptain ? '©️' : '');
        })->implode("\n");
    }

    private function getManagerTotalPointsText(): string
    {
        return "Всего очков: {$this->manager->picks->sum('points')}";
    }
}

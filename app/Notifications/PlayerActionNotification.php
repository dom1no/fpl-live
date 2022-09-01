<?php

namespace App\Notifications;

use App\Models\Enums\PlayerPointAction;
use App\Models\Fixture;
use App\Models\Player;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class PlayerActionNotification extends Notification
{
    private Player $player;
    private PlayerPointAction $action;
    private int $diffPoints;

    public function __construct(Player $player, PlayerPointAction $action, int $diffPoints)
    {
        $this->player = $player;
        $this->action = $action;
        $this->diffPoints = $diffPoints;
    }

    public function via(): array
    {
        return ['telegram'];
    }

    public function shouldSend(): bool
    {
        return in_array($this->action, [
            PlayerPointAction::GOALS_SCORED,
            PlayerPointAction::ASSISTS,
            PlayerPointAction::RED_CARDS,
            PlayerPointAction::YELLOW_CARDS,
            PlayerPointAction::OWN_GOALS,
            PlayerPointAction::PENALTIES_MISSED,
            PlayerPointAction::PENALTIES_SAVED,
        ], true);
    }

    public function toTelegram(): TelegramMessage
    {
        return TelegramMessage::create()
            ->content(implode("\n", [
                $this->getActionFullText(),
                $this->getFixtureScoreText(),
                $this->getPlayerPointsText(),
            ]));
    }

    private function getActionFullText(): string
    {
        return "{$this->getActionEmoji()} {$this->getActionTitleText()} {$this->getPlayerText()} {$this->getActionText()} {$this->getActionDiffPointText()}";
    }

    private function getActionEmoji(): string
    {
        return match ($this->action) {
            PlayerPointAction::GOALS_SCORED => '⚽',
            PlayerPointAction::ASSISTS => '🎯',
            PlayerPointAction::RED_CARDS => '🟥',
            PlayerPointAction::YELLOW_CARDS => '🟨',
            PlayerPointAction::OWN_GOALS => '🙃',
            PlayerPointAction::PENALTIES_MISSED => '❌',
            PlayerPointAction::PENALTIES_SAVED => '🧤',
        };
    }

    private function getActionTitleText(): string
    {
        return match ($this->action) {
            PlayerPointAction::GOALS_SCORED => 'Гол!',
            PlayerPointAction::ASSISTS => 'Голевая!',
            PlayerPointAction::RED_CARDS => 'Красная карточка!',
            PlayerPointAction::YELLOW_CARDS => 'Желтая карточка -',
            PlayerPointAction::OWN_GOALS => 'Автогол!',
            PlayerPointAction::PENALTIES_MISSED => '',
            PlayerPointAction::PENALTIES_SAVED => 'Сейв!',
        };
    }

    private function getActionText(): string
    {
        return match ($this->action) {
            PlayerPointAction::GOALS_SCORED => 'забил',
            PlayerPointAction::ASSISTS => 'отдал',
            PlayerPointAction::RED_CARDS => 'удален',
            PlayerPointAction::YELLOW_CARDS => '',
            PlayerPointAction::OWN_GOALS => 'забил в свои ворота',
            PlayerPointAction::PENALTIES_MISSED => 'не забил пенальти!',
            PlayerPointAction::PENALTIES_SAVED => 'отбил пенальти!',
        };
    }

    private function getActionDiffPointText(): string
    {
        $withSign = $this->diffPoints > 0 ? "+$this->diffPoints" : $this->diffPoints;

        return "({$withSign})";
    }

    private function getPlayerText(): string
    {
        return "*{$this->player->full_name}* **({$this->player->team->name})**";
    }

    private function getFixtureScoreText(): string
    {
        $fixture = $this->getCurrentFixture();
        $fixtureUrl = route('fixtures.show', $fixture);

        return "[{$fixture->home_team->name} {$fixture->score_formatted} {$fixture->away_team->name}]({$fixtureUrl}) {$fixture->minutes}";
    }

    private function getCurrentFixture(): Fixture
    {
        return $this->player->team->fixtures()->forCurrentGameweek()->first();
    }

    private function getPlayerPointsText(): string
    {
        return "Очки: {$this->player->points()->forCurrentGameweek()->sum('points')}";
    }
}

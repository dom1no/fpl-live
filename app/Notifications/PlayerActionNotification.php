<?php

namespace App\Notifications;

use App\Models\Enums\PlayerPointAction;
use App\Models\Fixture;
use App\Models\Manager;
use App\Models\PlayerPoint;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class PlayerActionNotification extends Notification
{
    protected PlayerPoint $playerPoint;

    public function __construct(PlayerPoint $playerPoint)
    {
        $this->playerPoint = $playerPoint;
    }

    public function via(): array
    {
        return ['telegram'];
    }

    public function shouldSend(): bool
    {
        return in_array($this->playerPoint->action, [
            PlayerPointAction::GOALS_SCORED,
            PlayerPointAction::ASSISTS,
            PlayerPointAction::RED_CARDS,
            PlayerPointAction::YELLOW_CARDS,
            PlayerPointAction::OWN_GOALS,
            PlayerPointAction::PENALTIES_MISSED,
            PlayerPointAction::PENALTIES_SAVED,
        ], true);
    }

    public function toTelegram(Manager $manager): TelegramMessage
    {
        return TelegramMessage::create()
            ->content(implode("\n", [
                $this->getActionFullText(),
                $this->getFixtureScoreText(),
                $this->getPlayerPointsText(),

                '',
                "`{$manager->name}`", // TODO: удалить, после выката для всех
            ]));
    }

    protected function getActionFullText(): string
    {
        return "{$this->getActionEmoji()} {$this->getActionTitleText()} {$this->getPlayerText()} {$this->getActionText()} {$this->getActionDiffPointText()}";
    }

    protected function getActionEmoji(): string
    {
        if ($this->playerPoint->value - $this->playerPoint->getOriginal('value') < 0) {
            return '🚫';
        }

        return match ($this->playerPoint->action) {
            PlayerPointAction::GOALS_SCORED => '⚽',
            PlayerPointAction::ASSISTS => '🎯',
            PlayerPointAction::RED_CARDS => '🟥',
            PlayerPointAction::YELLOW_CARDS => '🟨',
            PlayerPointAction::OWN_GOALS => '🙃',
            PlayerPointAction::PENALTIES_MISSED => '❌',
            PlayerPointAction::PENALTIES_SAVED => '🧤',
        };
    }

    protected function getActionTitleText(): string
    {
        return match ($this->playerPoint->action) {
            PlayerPointAction::GOALS_SCORED => match ((int) $this->playerPoint->value) {
                1 => 'Гол!',
                2 => 'Дубль!',
                3 => 'Хет-трик!',
                4 => 'Пента-трик!',
                5 => 'Покер!',
                default => "{$this->playerPoint->value}-й гол!",
            },
            PlayerPointAction::ASSISTS => 'Голевая!',
            PlayerPointAction::RED_CARDS => 'Красная карточка!',
            PlayerPointAction::YELLOW_CARDS => 'Желтая карточка -',
            PlayerPointAction::OWN_GOALS => 'Автогол!',
            PlayerPointAction::PENALTIES_MISSED => '',
            PlayerPointAction::PENALTIES_SAVED => 'Сейв!',
        };
    }

    protected function getActionText(): string
    {
        return match ($this->playerPoint->action) {
            PlayerPointAction::GOALS_SCORED => 'забил',
            PlayerPointAction::ASSISTS => 'отдал',
            PlayerPointAction::RED_CARDS => 'удален',
            PlayerPointAction::YELLOW_CARDS => '',
            PlayerPointAction::OWN_GOALS => 'забил в свои ворота',
            PlayerPointAction::PENALTIES_MISSED => 'не забил пенальти!',
            PlayerPointAction::PENALTIES_SAVED => 'отбил пенальти!',
        };
    }

    protected function getActionDiffPointText(): string
    {
        $diff = $this->getActionDiffPoints();
        $withSign = $diff > 0 ? "+{$diff}" : $diff;

        return "({$withSign})";
    }

    protected function getActionDiffPoints(): int
    {
        if (! $this->playerPoint->exists) {
            return -$this->playerPoint->getOriginal('points', 0);
        }

        return $this->playerPoint->points - $this->playerPoint->getOriginal('points', 0);
    }

    protected function getPlayerText(): string
    {
        return "*{$this->playerPoint->player->full_name}* **({$this->playerPoint->player->team->name})**";
    }

    protected function getFixtureScoreText(): string
    {
        $fixture = $this->getCurrentFixture();
        $fixtureUrl = route('fixtures.show', $fixture);

        return "[{$fixture->home_team->name} {$fixture->score_formatted} {$fixture->away_team->name}]({$fixtureUrl}) {$fixture->minutes}'";
    }

    protected function getCurrentFixture(): Fixture
    {
        return $this->playerPoint->player->team->fixtures()->forCurrentGameweek()->first();
    }

    protected function getPlayerPointsText(): string
    {
        return "Очки: {$this->playerPoint->player->points()->forCurrentGameweek()->sum('points')}";
    }
}

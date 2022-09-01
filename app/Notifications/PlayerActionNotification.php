<?php

namespace App\Notifications;

use App\Models\Enums\PlayerPointAction;
use App\Models\Fixture;
use App\Models\Manager;
use App\Models\Player;
use App\Models\PlayerPoint;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class PlayerActionNotification extends Notification
{
    private PlayerPoint $playerPoint;

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

                "\n",
                "´´´{$manager->name}´´´" // TODO: удалить, после выката для всех
            ]));
    }

    private function getActionFullText(): string
    {
        return "{$this->getActionEmoji()} {$this->getActionTitleText()} {$this->getPlayerText()} {$this->getActionText()} {$this->getActionDiffPointText()}";
    }

    private function getActionEmoji(): string
    {
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

    private function getActionTitleText(): string
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

    private function getActionText(): string
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

    private function getActionDiffPointText(): string
    {
        $diff = $this->playerPoint->points - $this->playerPoint->getOriginal('points', 0);
        $withSign = $diff > 0 ? "+{$diff}" : $diff;

        return "({$withSign})";
    }

    private function getPlayerText(): string
    {
        return "*{$this->playerPoint->player->full_name}* **({$this->playerPoint->player->team->name})**";
    }

    private function getFixtureScoreText(): string
    {
        $fixture = $this->getCurrentFixture();
        $fixtureUrl = route('fixtures.show', $fixture);

        return "[{$fixture->home_team->name} {$fixture->score_formatted} {$fixture->away_team->name}]({$fixtureUrl}) {$fixture->minutes}'";
    }

    private function getCurrentFixture(): Fixture
    {
        return $this->playerPoint->player->team->fixtures()->forCurrentGameweek()->first();
    }

    private function getPlayerPointsText(): string
    {
        return "Очки: {$this->playerPoint->player->points()->forCurrentGameweek()->sum('points')}";
    }
}

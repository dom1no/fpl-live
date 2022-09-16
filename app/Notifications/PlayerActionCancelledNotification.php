<?php

namespace App\Notifications;

use App\Models\Enums\PlayerPointAction;
use LogicException;

class PlayerActionCancelledNotification extends PlayerActionNotification
{
    protected function getActionFullText(): string
    {
        return "{$this->getActionEmoji()} {$this->getActionTitleText()} {$this->getPlayerText()} {$this->getActionDiffPointText()}";
    }

    protected function getTitleText(): string
    {
        return match ($this->playerPoint->action) {
            PlayerPointAction::ASSISTS => '🚫',
            default => '🚫🖥 ',
        };
    }

    protected function getActionTitleText(): string
    {
        return match ($this->playerPoint->action) {
            PlayerPointAction::GOALS_SCORED => 'Гол отменен!',
            PlayerPointAction::ASSISTS => 'Голевая отменена!',
            PlayerPointAction::RED_CARDS => 'Красная карточка отменена!',
            PlayerPointAction::YELLOW_CARDS => 'Желтая карточка отменена - ',
            PlayerPointAction::OWN_GOALS => 'Автогол отменен!',
            PlayerPointAction::PENALTIES_MISSED, PlayerPointAction::PENALTIES_SAVED => 'Пенальти будет перебит!',
            default => throw new LogicException("Unexpected action: {$this->playerPoint->action->name}"),
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
            default => throw new LogicException("Unexpected action: {$this->playerPoint->action->name}"),
        };
    }
}

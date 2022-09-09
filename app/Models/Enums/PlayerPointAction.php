<?php

namespace App\Models\Enums;

enum PlayerPointAction: string
{
    case MINUTES = 'minutes';
    case GOALS_SCORED = 'goals_scored';
    case ASSISTS = 'assists';
    case GOALS_CONCEDED = 'goals_conceded';
    case OWN_GOALS = 'own_goals';
    case PENALTIES_SAVED = 'penalties_saved';
    case PENALTIES_MISSED = 'penalties_missed';
    case YELLOW_CARDS = 'yellow_cards';
    case RED_CARDS = 'red_cards';
    case SAVES = 'saves';
    case BONUS = 'bonus';
    case CLEAN_SHEETS = 'clean_sheets';

    case PREDICTION_BONUS = 'prediction_bonus';

    public function title(): string
    {
        return match ($this) {
            self::MINUTES => 'Сыграно минут',
            self::GOALS_SCORED => 'Голы',
            self::ASSISTS => 'Ассисты',
            self::GOALS_CONCEDED => 'Пропущено голов',
            self::OWN_GOALS => 'Автоголы',
            self::PENALTIES_SAVED => 'Отбито пенальти',
            self::PENALTIES_MISSED => 'Не забито пенальти',
            self::YELLOW_CARDS => 'ЖК',
            self::RED_CARDS => 'КК',
            self::SAVES => 'Сейвы',
            self::BONUS => 'Бонусы',
            self::CLEAN_SHEETS => 'Сухой матч',
            self::PREDICTION_BONUS => 'Бонусы (live)',
        };
    }
}

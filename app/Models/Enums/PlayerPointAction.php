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

    public function sortValue(): int
    {
        return match ($this) {
            self::MINUTES => 1,
            self::GOALS_SCORED => 2,
            self::ASSISTS => 3,
            self::SAVES => 4,
            self::PENALTIES_SAVED => 5,
            self::CLEAN_SHEETS => 6,
            self::YELLOW_CARDS => 7,
            self::RED_CARDS => 8,
            self::GOALS_CONCEDED => 9,
            self::OWN_GOALS => 10,
            self::PENALTIES_MISSED => 11,
            self::BONUS => 12,
            self::PREDICTION_BONUS => 13,
        };
    }
}

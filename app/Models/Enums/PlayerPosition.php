<?php

namespace App\Models\Enums;

enum PlayerPosition: string
{
    case GOALKEEPER = 'GKP';
    case DEFENDER = 'DEF';
    case MIDFIELDER = 'MID';
    case FORWARD = 'FWD';

    public static function findByFplId(int $fplId): ?self
    {
        return match ($fplId) {
            1 => self::GOALKEEPER,
            2 => self::DEFENDER,
            3 => self::MIDFIELDER,
            4 => self::FORWARD,
            default => null
        };
    }

    public function title(): string
    {
        return match ($this) {
            self::GOALKEEPER => 'Вратарь',
            self::DEFENDER => 'Защита',
            self::MIDFIELDER => 'Полузащита',
            self::FORWARD => 'Нападение',
        };
    }

    public function playersCountInTeam(): string
    {
        return match ($this) {
            self::GOALKEEPER => 2,
            self::DEFENDER, self::MIDFIELDER => 5,
            self::FORWARD => 3,
        };
    }
}

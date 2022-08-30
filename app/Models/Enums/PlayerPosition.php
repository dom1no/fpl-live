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
}

<?php

namespace App\Models\Enums;

enum PlayerPosition: string
{
    case Goalkeeper = 'GKP';
    case Defender = 'DEF';
    case Midfielder = 'MID';
    case Forward = 'FWD';

    public static function findByFplId(int $fplId): ?self
    {
        return match ($fplId) {
            1 => self::Goalkeeper,
            2 => self::Defender,
            3 => self::Midfielder,
            4 => self::Forward,
            default => null
        };
    }
}

<?php

namespace App\Models\Enums;

use App\Models\Player;

enum PlayerStatus: string
{
    case OK = 'ok';
    case MINOR_INJURY = 'minor_injury';
    case MAJOR_INJURY = 'major_injury';
    case NOT_AVAILABLE = 'not_available';

    public static function findByFplStatus(string $fplStatus): ?self
    {
        return match ($fplStatus) {
            'a' => self::OK,
            'd' => self::MINOR_INJURY,
            'i', 'n' => self::MAJOR_INJURY, // i - травма, n - запрет на матч со своим клубом, если в аренде
            'u' => self::NOT_AVAILABLE,
            default => null
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::OK => '',
            self::MINOR_INJURY, self::MAJOR_INJURY => 'phosphor-warning-fill',
            self::NOT_AVAILABLE => 'phosphor-minus-circle-fill',
        };
    }

    public function color(Player $player): string
    {
        return match ($this) {
            self::OK => '',
            self::MINOR_INJURY => match ((int) $player->chance_of_playing) {
                75 => 'yellow',
                50 => 'orange-light',
                25 => 'warning',
                default => 'danger'
            },
            self::MAJOR_INJURY => 'danger',
            self::NOT_AVAILABLE => 'light',
        };
    }
}

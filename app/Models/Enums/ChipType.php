<?php

namespace App\Models\Enums;

enum ChipType: string
{
    case WILDCARD = 'wildcard';
    case BENCH_BOOST = 'bboost';
    case TRIPLE_CAPTAIN = '3xc';
    case FREE_HIT = 'freehit';

    public function title(): string
    {
        return match ($this) {
            self::WILDCARD => 'Wildcard',
            self::BENCH_BOOST => 'Bench Boost',
            self::TRIPLE_CAPTAIN => 'Triple Captain',
            self::FREE_HIT => 'Free Hit',
        };
    }

    public function availableTimes(): int
    {
        return match ($this) {
            self::WILDCARD => 2,
            self::BENCH_BOOST => 1,
            self::TRIPLE_CAPTAIN => 1,
            self::FREE_HIT => 1,
        };
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Player;
use App\Models\PlayerStats;
use App\Services\FotMob\FotMobService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ImportFotMobPlayersStatsCommand extends Command
{
    protected $signature = 'fot-mob:players-stats {--current}';

    protected $description = 'Import players stats from fot mob';

    public function handle(FotMobService $fotMobService): void
    {
        Gameweek::query()
            ->with('fixtures')
            ->finishedOrCurrent()
            ->when($this->option('current'), fn ($q) => $q->where('is_current', true))
            ->each(function (Gameweek $gameweek) use ($fotMobService) {
                $gameweek->fixtures->each(function (Fixture $fixture) use ($gameweek, $fotMobService) {
                    $matchLineup = $fotMobService->getMatchLineup($fixture);

                    $this->saveFixturePlayersStats($matchLineup, $gameweek);
                });
            });
    }

    private function saveFixturePlayersStats(Collection $matchLineup, Gameweek $gameweek): void
    {
        if ($matchLineup->isEmpty()) {
            return;
        }

        $mainPlayers = $matchLineup->pluck('players')->flatten(2);
        $benchPlayers = $matchLineup->pluck('bench')->flatten(1);

        $fotMobIds = $mainPlayers->pluck('id')->merge($benchPlayers->pluck('id'));
        $players = Player::whereIn('fot_mob_id', $fotMobIds)->pluck('id', 'fot_mob_id');

        foreach ($mainPlayers as $playerData) {
            $this->upsertPlayerStats($playerData, $players, $gameweek, isMain: true);
        }

        foreach ($benchPlayers as $playerData) {
            $this->upsertPlayerStats($playerData, $players, $gameweek, isBench: true);
        }
    }

    private function upsertPlayerStats(array $playerData, Collection $players, Gameweek $gameweek, bool $isMain = false, bool $isBench = false): void
    {
        $playerTopStats = collect($playerData['stats'] ?? [])->firstWhere('title', 'Top stats');
        if (! $playerTopStats) {
            return;
        }

        $playerStats = $playerTopStats['stats'];

        PlayerStats::updateOrCreate([
            'gameweek_id' => $gameweek->id,
            'player_id' => $players->get($playerData['id']),
        ], [
            'xg' => $playerStats['Expected goals (xG)'] ?? null,
            'xa' => $playerStats['Expected assists (xA)'] ?? null,
            'fot_mob_rating' => $playerStats['FotMob rating'] ?? null,
            'is_main' => $isMain,
            'is_bench' => $isBench,
        ]);
    }
}

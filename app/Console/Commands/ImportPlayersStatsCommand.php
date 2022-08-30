<?php

namespace App\Console\Commands;

use App\Models\Enums\PlayerPointAction;
use App\Models\Gameweek;
use App\Models\ManagerPick;
use App\Models\Player;
use App\Models\PlayerPoint;
use App\Models\PlayerStats;
use App\Services\FPL\FPLService;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ImportPlayersStatsCommand extends Command
{
    protected $signature = 'import:players-stats';

    protected $description = 'Import players stats from FPL API';

    private Collection $players;

    public function handle(FPLService $FPLService): void
    {
        $this->info('Starting import players stats...');

        $this->players = Player::pluck('id', 'fpl_id');

        Gameweek::finished()->each(function (Gameweek $gameweek) use ($FPLService) {
            $stats = $FPLService->getPlayersStatsByGameweek($gameweek);
            $this->importStats($stats, $gameweek);
        });

        $this->info('Finished import players stats.');
    }

    private function importStats(Collection $stats, Gameweek $gameweek): void
    {
        foreach ($stats as $playerData) {
            $playerId = $this->players->get($playerData['id']);

            $this->upsertPlayerStats($playerData['stats'], $playerId, $gameweek);
            $this->upsertPlayerPoints(head($playerData['explain'])['stats'], $playerId, $gameweek);
        }
    }

    private function upsertPlayerStats(array $playerStats, int $playerId, Gameweek $gameweek): void
    {
        PlayerStats::updateOrCreate([
            'player_id' => $playerId,
            'gameweek_id' => $gameweek->id,
        ], [
            'minutes' => $playerStats['minutes'],
            'goals_scored' => $playerStats['goals_scored'],
            'assists' => $playerStats['assists'],
            'goals_conceded' => $playerStats['goals_conceded'],
            'own_goals' => $playerStats['own_goals'],
            'penalties_saved' => $playerStats['penalties_saved'],
            'penalties_missed' => $playerStats['penalties_missed'],
            'yellow_cards' => $playerStats['yellow_cards'],
            'red_cards' => $playerStats['red_cards'],
            'saves' => $playerStats['saves'],
            'bonus' => $playerStats['bonus'],
            'bps' => $playerStats['bps'],
            'influence' => $playerStats['influence'],
            'creativity' => $playerStats['creativity'],
            'threat' => $playerStats['threat'],
            'ict_index' => $playerStats['ict_index'],
        ]);
    }

    private function upsertPlayerPoints(array $playerPoints, int $playerId, Gameweek $gameweek): void
    {
        foreach ($playerPoints as $playerPoint) {
            PlayerPoint::updateOrCreate([
                'player_id' => $playerId,
                'gameweek_id' => $gameweek->id,
                'action' => PlayerPointAction::from($playerPoint['identifier'])
            ], [
                'value' => $playerPoint['value'],
                'points' => $playerPoint['points'],
            ]);
        }

        $this->updateManagerPicksPoints($playerId, $gameweek, $playerPoints);
    }

    private function updateManagerPicksPoints(int $playerId, Gameweek $gameweek, array $playerPoints): void
    {
        ManagerPick::where('player_id', $playerId)->where('gameweek_id', $gameweek->id)->update([
            'points' => DB::raw(collect($playerPoints)->sum('points') . '* `multiplier`'),
        ]);
    }
}

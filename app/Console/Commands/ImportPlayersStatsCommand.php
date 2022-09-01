<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\HasImportedCount;
use App\Console\Commands\Traits\HasMeasure;
use App\Models\Enums\PlayerPointAction;
use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\ManagerPick;
use App\Models\Player;
use App\Models\PlayerPoint;
use App\Models\PlayerStats;
use App\Services\FPL\FPLService;
use App\Services\PlayerStatsService;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ImportPlayersStatsCommand extends Command
{
    use HasImportedCount;
    use HasMeasure;

    protected $signature = 'import:players-stats {--current}';

    protected $description = 'Import players stats from FPL API';

    private Collection $players;

    public function handle(FPLService $FPLService): void
    {
        $this->startMeasure();
        $this->info('Starting import players stats...');

        $this->players = Player::pluck('id', 'fpl_id');

        Gameweek::query()
            ->finishedOrCurrent()
            ->when($this->option('current'), fn ($q) => $q->where('is_current', true))
            ->each(function (Gameweek $gameweek) use ($FPLService) {
                $stats = $FPLService->getPlayersStatsByGameweek($gameweek);
                $this->importStats($stats, $gameweek);

                if ($gameweek->is_current) {
                    $this->upsertPredictedBonusPoints($gameweek);
                }

                $this->updateManagersPicksPoints($gameweek);
            });

        $this->finishMeasure();
        $this->info("Finished import players stats. {$this->importedCountText('players stats')} {$this->durationText()}");
    }

    private function importStats(Collection $stats, Gameweek $gameweek): void
    {
        foreach ($stats as $playerData) {
            $playerId = $this->players->get($playerData['id']);

            $this->upsertPlayerStats($playerData['stats'], $playerId, $gameweek);
            $this->upsertPlayerPoints(head($playerData['explain'])['stats'], $playerId, $gameweek);

            $this->importedInc();
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
            if ($this->option('current')) {
                $this->upsertPlayerPoint($playerPoint, $playerId, $gameweek);
            } else {
                PlayerPoint::withoutEvents(fn() => $this->upsertPlayerPoint($playerPoint, $playerId, $gameweek));
            }
        }
    }

    private function upsertPlayerPoint(array $playerPoint, int $playerId, Gameweek $gameweek)
    {
        PlayerPoint::updateOrCreate([
            'player_id' => $playerId,
            'gameweek_id' => $gameweek->id,
            'action' => PlayerPointAction::from($playerPoint['identifier']),
        ], [
            'value' => $playerPoint['value'],
            'points' => $playerPoint['points'],
        ]);
    }

    private function upsertPredictedBonusPoints(Gameweek $gameweek): void
    {
        $fixtures = Fixture::select('id', 'is_bonuses_added')
            ->forGameweek($gameweek)
            ->where('is_started', true)
            ->where('kickoff_time', '<', now()->subMinutes(30))
            ->with('teams:id')
            ->get();

        $players = Player::select('id', 'team_id', 'fpl_id')
            ->whereIn('team_id', $fixtures->pluck('teams.*.id')->collapse())
            ->with([
                'gameweekStats' => fn ($q) => $q->select('player_id', 'bps')->forGameweek($gameweek),
            ])
            ->get();

        foreach ($fixtures as $fixture) {
            $fixturePlayers = $players->whereIn('team_id', $fixture->teams->pluck('id'));

            if ($fixture->is_bonuses_added) {
                PlayerPoint::whereIn('player_id', $fixturePlayers->modelKeys())
                    ->where('action', PlayerPointAction::PREDICTION_BONUS)
                    ->delete();

                continue;
            }

            $playerStatsService = app(PlayerStatsService::class);
            $calculatedBpsBonuses = $playerStatsService->calculateBpsBonuses($fixturePlayers);

            foreach ($calculatedBpsBonuses as $playerId => $bonus) {
                PlayerPoint::updateOrCreate([
                    'player_id' => $playerId,
                    'gameweek_id' => $gameweek->id,
                    'action' => PlayerPointAction::PREDICTION_BONUS,
                ], [
                    'value' => $bonus,
                    'points' => $bonus,
                ]);
            }
        }
    }

    private function updateManagersPicksPoints(Gameweek $gameweek): void
    {
        $playersPoints = PlayerPoint::select('player_id', DB::raw('SUM(points) as total_points'))
            ->forGameweek($gameweek)
            ->groupBy('player_id')
            ->pluck('total_points', 'player_id');

        foreach ($playersPoints as $playerId => $playerPoints) {
            ManagerPick::forGameweek($gameweek)
                ->where('player_id', $playerId)
                ->update([
                    'points' => DB::raw("{$playerPoints} * `multiplier`"),
                ]);
        }
    }
}

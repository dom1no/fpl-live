<?php

namespace App\Console\Commands;

use App\Models\Enums\PlayerPointAction;
use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Manager;
use App\Models\ManagerPick;
use App\Models\ManagerPointsHistory;
use App\Models\Player;
use App\Models\PlayerPoint;
use App\Models\PlayerStats;
use App\Services\FPL\FPLService;
use App\Services\PlayerStatsService;
use DB;
use Illuminate\Support\Collection;

class ImportPlayersStatsCommand extends FPLImportCommand
{
    private Collection $players;

    public function entityName(): string
    {
        return 'players stats';
    }

    public function signatureArgs(): string
    {
        return '{--current}';
    }

    protected function import(FPLService $FPLService): void
    {
        $this->players = Player::pluck('id', 'fpl_id');

        Gameweek::query()
            ->finishedOrCurrent()
            ->when($this->option('current'), fn ($q) => $q->where('is_current', true))
            ->tap(fn ($query) => $this->startProgressBar($query->count()))
            ->each(function (Gameweek $gameweek) use ($FPLService) {
                $stats = $FPLService->getPlayersStatsByGameweek($gameweek);
                $this->importStats($stats, $gameweek);

                $this->calcFixturesLiveMinutes($gameweek);

                if ($gameweek->is_current) {
                    $this->upsertPredictedBonusPoints($gameweek);
                }

                $this->updateManagersPicksPoints($gameweek);
                $this->updateManagersPointsHistory($gameweek);

                $this->advanceProgressBar();
            });

        $this->updateManagersTotalPoints();
    }

    private function importStats(Collection $stats, Gameweek $gameweek): void
    {
        foreach ($stats as $playerData) {
            $playerId = $this->players->get($playerData['id']);

            $this->upsertPlayerStats($playerData['stats'], $playerId, $gameweek);
            $this->syncPlayerPoints(head($playerData['explain'])['stats'] ?? [], $playerId, $gameweek);

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

    private function syncPlayerPoints(array $playerPoints, int $playerId, Gameweek $gameweek): void
    {
        $existedPointsIds = PlayerPoint::forGameweek($gameweek)->where('player_id', $playerId)->pluck('id');
        $importedPointsIds = [];

        foreach ($playerPoints as $playerPoint) {
            if ($this->option('current')) {
                $playerPoint = $this->upsertPlayerPoint($playerPoint, $playerId, $gameweek);
            } else {
                $playerPoint = PlayerPoint::withoutEvents(fn () => $this->upsertPlayerPoint($playerPoint, $playerId, $gameweek));
            }

            $importedPointsIds[] = $playerPoint->id;
        }

        PlayerPoint::findMany($existedPointsIds->diff($importedPointsIds))->each->delete();
    }

    private function upsertPlayerPoint(array $playerPoint, int $playerId, Gameweek $gameweek): PlayerPoint
    {
        return PlayerPoint::updateOrCreate([
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
            ->where('minutes', '>=', 45)
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
                    'clean_points' => $playerPoints,
                ]);
        }
    }

    private function updateManagersPointsHistory(Gameweek $gameweek): void
    {
        Manager::query()
            ->with('pointsHistory')
            ->withSum([
                'picks as gameweek_points' => fn ($q) => $q->forGameweek($gameweek),
            ], 'points')
            ->each(function (Manager $manager) use ($gameweek) {
                $previousPointsHistory = $manager->pointsHistory
                    ->sortByDesc('gameweek_id')
                    ->firstWhere('gameweek_id', '<', $gameweek->id);
                $currentPointsHistory = $manager->pointsHistory
                    ->firstWhere('gameweek_id', $gameweek->id)
                    ?: new ManagerPointsHistory(['manager_id' => $manager->id, 'gameweek_id' => $gameweek->id]);

                $currentPointsHistory->fill([
                    'points' => $manager->gameweek_points ?: 0,
                    'total_points' => ($previousPointsHistory->total_points ?? 0)
                        + $manager->gameweek_points
                        - $currentPointsHistory->transfers_cost,
                ])->save();
            });
    }

    private function calcFixturesLiveMinutes(Gameweek $gameweek): void
    {
        Fixture::forGameweek($gameweek)
            ->where('is_started', true)
            ->where('is_finished', false)
            ->where('is_finished_provisional', false)
            ->with('teams:id')
            ->each(function (Fixture $fixture) use ($gameweek) {
                $maxFixturePlayerMinutes = PlayerStats::forGameweek($gameweek)
                    ->whereHas('player', function ($q) use ($fixture) {
                        $q->whereIn('team_id', $fixture->teams->pluck('id'));
                    })
                    ->max('minutes');

                $fixture->update(['minutes' => $maxFixturePlayerMinutes]);
            });
    }

    private function updateManagersTotalPoints(): void
    {
        Manager::with([
            'gameweekPointsHistory' => fn ($q) => $q->latest('gameweek_id'),
        ])
            ->each(function (Manager $manager) {
                $manager->update([
                    'total_points' => $manager->gameweekPointsHistory->total_points,
                ]);
            });
    }
}

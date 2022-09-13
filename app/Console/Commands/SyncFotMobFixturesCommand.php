<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Services\FotMob\FotMobService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class SyncFotMobFixturesCommand extends Command
{
    protected $signature = 'fot-mob:sync-fixtures {--stats} {--current}';

    protected $description = 'Sync fixtures from fot mob';

    private Collection $matchesData;

    public function handle(FotMobService $fotMobService): void
    {
        $this->matchesData = $fotMobService->getMatches();

        Fixture::orderBy('gameweek_id')
            ->with('teams', 'gameweek')
            ->each(function (Fixture $fixture) {
                $fixture->update([
                    'fot_mob_id' => $this->mapFotMobId($fixture),
                ]);

                if ($this->option('stats') && (! $this->option('current') || $fixture->gameweek->is_current)) {
                    $this->importStats($fixture);
                }
            });
    }

    public function mapFotMobId(Fixture $fixture): ?int
    {
        $matchDataKey = $this->matchesData->search(function (array $matchData) use ($fixture) {
            return $matchData['home']['id'] == $fixture->home_team->fot_mob_id
                && $matchData['away']['id'] == $fixture->away_team->fot_mob_id;
        });
        if ($matchDataKey === false) {
            return null;
        }

        $matchData = $this->matchesData->pull($matchDataKey);

        return $matchData['id'];
    }

    public function importStats(Fixture $fixture): void
    {
        if ($fixture->isFeature()) {
            return;
        }

        $fotMobService = app(FotMobService::class);
        $matchStats = $fotMobService->getMatchStats($fixture);

        $xgStats = $matchStats->firstWhere('title', 'EXPECTED GOALS (xG)');
        if (! $xgStats) {
            return;
        }

        $xgData = collect($xgStats['stats'])->where('title', 'Expected goals (xG)')->firstWhere('type', 'text');
        if (! $xgData) {
            return;
        }

        $fixture->teams()->updateExistingPivot($fixture->home_team->id, [
            'xg' => $xgData['stats'][0] ?? null,
        ]);
        $fixture->teams()->updateExistingPivot($fixture->away_team->id, [
            'xg' => $xgData['stats'][1] ?? null,
        ]);
    }
}

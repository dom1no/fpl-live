<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\HasImportedCount;
use App\Console\Commands\Traits\HasMeasure;
use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Team;
use App\Services\FPL\FPLService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ImportFixturesCommand extends Command
{
    use HasImportedCount;
    use HasMeasure;

    protected $signature = 'import:fixtures {--current}';

    protected $description = 'Import fixtures from FPL API';

    private Collection $teams;

    public function handle(FPLService $FPLService): void
    {
        $this->startMeasure();
        $this->info('Starting import fixtures...');

        $this->teams = Team::pluck('id', 'fpl_id');

        Gameweek::query()
            ->when($this->option('current'), fn ($q) => $q->where('is_current', true))
            ->each(function (Gameweek $gameweek) use ($FPLService) {
                $fixturesData = $FPLService->getFixturesByGameweek($gameweek);
                $this->importFixtures($fixturesData, $gameweek);
            });

        $this->finishMeasure();
        $this->info("Finished import fixtures. {$this->importedCountText('fixture')} {$this->durationText()}");
    }

    private function importFixtures(Collection $fixturesData, Gameweek $gameweek): void
    {
        foreach ($fixturesData as $fixtureData) {
            $fixtureBonusStats = collect($fixtureData['stats'])->firstWhere('identifier', 'bonus') ?? [];

            $fixture = Fixture::updateOrCreate([
                'fpl_id' => $fixtureData['id'],
            ], [
                'gameweek_id' => $gameweek->id,
                'kickoff_time' => Carbon::parse($fixtureData['kickoff_time'])->addHours(3),
                'is_started' => $fixtureData['started'],
                'is_finished' => $fixtureData['finished'],
                'is_finished_provisional' => $fixtureData['finished_provisional'],
                'is_bonuses_added' => !empty($fixtureBonusStats['a'] ?? false) || !empty($fixtureBonusStats['h'] ?? false),
                'minutes' => $fixtureData['minutes'],
            ]);

            $fixture->teams()->sync([
                $this->teams->get($fixtureData['team_h']) => [
                    'is_home' => true,
                    'score' => $fixtureData['team_h_score'],
                ],
                $this->teams->get($fixtureData['team_a']) => [
                    'is_home' => false,
                    'score' => $fixtureData['team_a_score'],
                ],
            ]);

            $this->importedInc();
        }
    }
}

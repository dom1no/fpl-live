<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Team;
use App\Services\FPL\FPLService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class ImportFixturesCommand extends Command
{
    protected $signature = 'import:fixtures {--current}';

    protected $description = 'Import fixtures from FPL API';

    private Collection $teams;

    public function handle(FPLService $FPLService): void
    {
        $this->info('Starting import fixtures...');

        $this->teams = Team::pluck('id', 'fpl_id');

        Gameweek::query()
            ->when($this->option('current'), fn($q) => $q->where('is_current', true))
            ->each(function (Gameweek $gameweek) use ($FPLService) {
                $fixturesData = $FPLService->getFixturesByGameweek($gameweek);
                $this->importFixtures($fixturesData, $gameweek);
            });

        $this->info('Finished import fixtures.');
    }

    private function importFixtures(Collection $fixturesData, Gameweek $gameweek): void
    {
        foreach ($fixturesData as $fixtureData) {
            $fixture = Fixture::updateOrCreate([
                'fpl_id' => $fixtureData['id'],
            ], [
                'gameweek_id' => $gameweek->id,
                'kickoff_time' => Carbon::parse($fixtureData['kickoff_time'])->addHours(3),
                'is_started' => $fixtureData['started'],
                'is_finished' => $fixtureData['finished'],
                'is_finished_provisional' => $fixtureData['finished_provisional'],
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
        }
    }
}

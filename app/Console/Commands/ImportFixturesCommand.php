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
                $fixtures = $FPLService->getFixturesByGameweek($gameweek);
                $this->importFixtures($fixtures, $gameweek);
            });

        $this->info('Finished import fixtures.');
    }

    private function importFixtures(Collection $fixtures, Gameweek $gameweek): void
    {
        foreach ($fixtures as $fixture) {
            Fixture::updateOrCreate([
                'fpl_id' => $fixture['id'],
            ], [
                'gameweek_id' => $gameweek->id,
                'kickoff_time' => Carbon::parse($fixture['kickoff_time']),
                'is_started' => $fixture['started'],
                'is_finished' => $fixture['finished'],
                'is_finished_provisional' => $fixture['finished_provisional'],
                'minutes' => $fixture['minutes'],
                'home_team_id' => $this->teams->get($fixture['team_h']),
                'away_team_id' => $this->teams->get($fixture['team_a']),
                'home_team_score' => $fixture['team_h_score'],
                'away_team_score' => $fixture['team_a_score'],
            ]);
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Team;
use App\Services\FPL\FPLService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ImportFixturesCommand extends FPLImportCommand
{
    private Collection $teams;

    public function entityName(): string
    {
        return 'fixtures';
    }

    public function signatureArgs(): string
    {
        return '{--current}';
    }

    protected function import(FPLService $FPLService): void
    {
        $this->teams = Team::pluck('id', 'fpl_id');

        Gameweek::query()
            ->when($this->option('current'), fn ($q) => $q->where('is_current', true))
            ->each(function (Gameweek $gameweek) use ($FPLService) {
                $fixturesData = $FPLService->getFixturesByGameweek($gameweek);
                $this->importFixtures($fixturesData, $gameweek);
            });
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
                'is_bonuses_added' => ! empty($fixtureBonusStats['a'] ?? false) || ! empty($fixtureBonusStats['h'] ?? false),
                // 'minutes' => $fixtureData['minutes'], //TODO: FPL всегда отдает 0 для текущих матчей
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

<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\Gameweek;
use App\Models\Team;
use App\Services\FPL\FPLService;
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
            ->tap(fn ($q) => $this->startProgressBar($q->count()))
            ->each(function (Gameweek $gameweek) use ($FPLService) {
                $fixturesData = $FPLService->getFixturesByGameweek($gameweek);
                $this->importFixtures($fixturesData, $gameweek);

                $this->advanceProgressBar();
            });
    }

    private function importFixtures(Collection $fixturesData, Gameweek $gameweek): void
    {
        $existedFixturesIds = Fixture::where('gameweek_id', $gameweek->id)->pluck('id');
        $importedFixturesIds = [];

        foreach ($fixturesData as $fixtureData) {
            if ($this->option('current')) {
                $fixture = $this->upsertFixture($fixtureData, $gameweek);
            } else {
                $fixture = Fixture::withoutEvents(fn () => $this->upsertFixture($fixtureData, $gameweek));
            }

            $importedFixturesIds[] = $fixture->id;
            $this->importedInc();
        }

        Fixture::findMany($existedFixturesIds->diff($importedFixturesIds))->each->delete();
    }

    private function upsertFixture(array $fixtureData, Gameweek $gameweek): Fixture
    {
        $fixtureBonusStats = collect($fixtureData['stats'])->firstWhere('identifier', 'bonus') ?? [];

        $fixture = Fixture::updateOrCreate([
            'fpl_id' => $fixtureData['id'],
        ], [
            'gameweek_id' => $gameweek->id,
            'kickoff_time' => $this->parseDate($fixtureData['kickoff_time']),
            'is_started' => $fixtureData['started'],
            'is_finished' => $fixtureData['finished'],
            'is_finished_provisional' => $fixtureData['finished_provisional'],
            'is_bonuses_added' => ! empty($fixtureBonusStats['a'] ?? false) || ! empty($fixtureBonusStats['h'] ?? false),
            // 'minutes' => $fixtureData['minutes'], //TODO: FPL ???????????? ???????????? 0 ?????? ?????????????? ????????????
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

        return $fixture;
    }
}

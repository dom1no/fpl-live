<?php

namespace App\Console\Commands;

use App\Models\Enums\PlayerPosition;
use App\Models\Gameweek;
use App\Models\Player;
use App\Models\Team;
use App\Services\FPL\FPLService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportBaseDataCommand extends Command
{
    protected $signature = 'import:base-data';

    protected $description = 'Import base data from FPL API';

    public function handle(FPLService $FPLService): void
    {
        $data = $FPLService->getBootstrapStatic();

        $this->importTeams($data);
        $this->importPlayers($data);
        $this->importGameweeks($data);
    }

    private function importTeams(array $data): void
    {
        $this->info('Starting import teams...');

        $teamsData = $data['teams'];

        $importedCount = 0;
        foreach ($teamsData as $teamData) {
            Team::updateOrCreate([
                'fpl_id' => $teamData['id'],
            ], [
                'name' => $teamData['name'],
                'short_name' => $teamData['short_name'],
            ]);
            $importedCount++;
        }

        $this->info("Finished import teams. Imported {$importedCount} teams.");
    }

    private function importPlayers(array $data): void
    {
        $this->info('Starting import players...');

        $playersData = $data['elements'];

        $teamsIds = Team::pluck('id', 'fpl_id');

        $importedCount = 0;
        foreach ($playersData as $playerData) {
            Player::updateOrCreate([
                'fpl_id' => $playerData['id'],
            ], [
                'name' => $playerData['web_name'],
                'full_name' => "{$playerData['first_name']} {$playerData['second_name']}",
                'position' => PlayerPosition::findByFplId($playerData['element_type']),
                'price' => $playerData['now_cost'] / 10,
                'team_id' => $teamsIds->get($playerData['team']),
            ]);
            $importedCount++;
        }

        $this->info("Finished import players. Imported {$importedCount} players.");
    }

    // TODO: отдельная команда
    private function importGameweeks(array $data): void
    {
        $this->info('Starting import gameweeks...');

        $gameweeksData = $data['events'];

        $importedCount = 0;
        foreach ($gameweeksData as $playerData) {
            Gameweek::updateOrCreate([
                'fpl_id' => $playerData['id'],
            ], [
                'name' => $playerData['name'],
                'deadline_at' => Carbon::parse($playerData['deadline_time_epoch'])->addHours(3),
                'is_finished' => $playerData['finished'],
                'is_previous' => $playerData['is_previous'],
                'is_current' => $playerData['is_current'],
                'is_next' => $playerData['is_next'],
            ]);
            $importedCount++;
        }

        $this->info("Finished import gameweeks. Imported {$importedCount} gameweeks.");
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Services\FPL\FPLService;
use Storage;

class ImportTeamsCommand extends FPLImportCommand
{
    public function entityName(): string
    {
        return 'teams';
    }

    public function signatureArgs(): string
    {
        return '{--shirts}';
    }

    protected function import(FPLService $FPLService): void
    {
        $data = $FPLService->getBootstrapStatic();
        $teamsData = $data['teams'];
        $this->startProgressBar(count($teamsData));

        foreach ($teamsData as $teamData) {
            $team = Team::updateOrCreate([
                'fpl_id' => $teamData['id'],
            ], [
                'name' => $teamData['name'],
                'short_name' => $teamData['short_name'],
            ]);

            if ($this->option('shirts')) {
                $this->downloadShirts($team, $teamData);
            }

            $this->importedInc();
            $this->advanceProgressBar();
        }
    }

    private function downloadShirts(Team $team, array $teamData): void
    {
        $exts = ['png', 'webp'];
        $widths = [66, 110, 220];

        $fplShirtName = "shirt_{$teamData['code']}";
        $fplShirtGKPName = "{$fplShirtName}_1";

        $disk = Storage::disk('shirts');

        foreach ($exts as $ext) {
            foreach ($widths as $width) {
                $disk->put(
                    $team->getFileShirtName($width, $ext),
                    $this->downloadShirtImg($fplShirtName, $width, $ext)
                );
                $disk->put(
                    $team->getFileShirtName($width, $ext, true),
                    $this->downloadShirtImg($fplShirtGKPName, $width, $ext),
                );
            }
        }
    }

    private function downloadShirtImg(string $shirtName, string $width, string $ext): string|false
    {
        $fileName = "{$shirtName}-{$width}.{$ext}";

        return file_get_contents(
            "https://fantasy.premierleague.com/dist/img/shirts/standard/{$fileName}"
        );
    }
}

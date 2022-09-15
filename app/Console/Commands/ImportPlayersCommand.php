<?php

namespace App\Console\Commands;

use App\Models\Enums\PlayerPosition;
use App\Models\Enums\PlayerStatus;
use App\Models\Player;
use App\Models\Team;
use App\Services\FPL\FPLService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Storage;

class ImportPlayersCommand extends FPLImportCommand
{
    public function entityName(): string
    {
        return 'players';
    }

    public function signatureArgs(): string
    {
        return '{--photos} {--force}';
    }

    protected function import(FPLService $FPLService): void
    {
        $data = $FPLService->getBootstrapStatic();
        $playersData = $data['elements'];
        $this->startProgressBar(count($playersData));

        $teamsIds = Team::pluck('id', 'fpl_id');

        foreach ($playersData as $playerData) {
            $parsedNews = $this->parseNews($playerData['news']);

            $player = Player::updateOrCreate([
                'fpl_id' => $playerData['id'],
            ], [
                'name' => $playerData['web_name'],
                'full_name' => "{$playerData['first_name']} {$playerData['second_name']}",
                'position' => PlayerPosition::findByFplId($playerData['element_type']),
                'price' => $playerData['now_cost'] / 10,
                'team_id' => $teamsIds->get($playerData['team']),
                'status' => PlayerStatus::findByFplStatus($playerData['status']),
                'status_comment' => $parsedNews['status_comment'] ?? null,
                'status_at' => $this->parseDate($playerData['news_added']),
                'chance_of_playing' => $parsedNews['chance_of_playing'] ?? null,
                'returned_at' => $parsedNews['returned_at'] ?? null,
            ]);

            if ($this->option('photos')) {
                $this->downloadPhotos($player, $playerData);
            }

            $this->importedInc();
            $this->advanceProgressBar();
        }
    }

    private function parseNews(string $news): ?array
    {
        if (! $news) {
            return null;
        }

        $str = Str::of($news);

        $statusComment = $str->before(' - ');
        $chanceOfPlaying = $str->whenContains(
            '% chance of playing',
            fn ($str) => $str->between(' - ', '% chance of playing')->replaceMatches('/[^0-9]/', ''),
            fn () => Str::of(''));

        $returnDate = null;
        if ($str->after(' - ')->startsWith('Expected back')) {
            $returnDate = Carbon::parse($str->after(' - Expected back '));

            if ($returnDate->isPast()) {
                $returnDate->addYear();
            }
        }

        return [
            'status_comment' => $statusComment->toString(),
            'chance_of_playing' => $chanceOfPlaying->isNotEmpty() ? (int) $chanceOfPlaying->toString() : null,
            'returned_at' => $returnDate,
        ];
    }

    private function downloadPhotos(Player $player, array $playerData): void
    {
        $localPhotoName = $player->getFilePhotoName();

        $disk = Storage::disk('player-photos');
        if (! $this->option('force') && $disk->exists($localPhotoName)) {
            return;
        }

        $fplPhotoName = Str::of($playerData['photo'])->prepend('p')->replace('jpg', 'png');

        $image = $this->downloadPhotoImg($fplPhotoName);
        if (! $image) {
            return;
        }

        $disk->put(
            $player->getFilePhotoName(),
            $image
        );
    }

    private function downloadPhotoImg(string $photoName): string|false
    {
        return rescue(fn () => file_get_contents(
            "https://resources.premierleague.com/premierleague/photos/players/110x140/{$photoName}"
        ), false);
    }
}

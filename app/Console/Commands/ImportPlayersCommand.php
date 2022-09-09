<?php

namespace App\Console\Commands;

use App\Models\Enums\PlayerPosition;
use App\Models\Player;
use App\Models\Team;
use App\Services\FPL\FPLService;
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
        return '{--photos}';
    }

    // TODO: выгружать данные по травмам, фото, status
    // status: a - все ок, i - травма (точно не сыграет), d - повреждение (возможно сыграет), u - ушел (аренда/трансфер)
    protected function import(FPLService $FPLService): void
    {
        $data = $FPLService->getBootstrapStatic();
        $playersData = $data['elements'];
        $this->startProgressBar(count($playersData));

        $teamsIds = Team::pluck('id', 'fpl_id');

        foreach ($playersData as $playerData) {
            $player = Player::updateOrCreate([
                'fpl_id' => $playerData['id'],
            ], [
                'name' => $playerData['web_name'],
                'full_name' => "{$playerData['first_name']} {$playerData['second_name']}",
                'position' => PlayerPosition::findByFplId($playerData['element_type']),
                'price' => $playerData['now_cost'] / 10,
                'team_id' => $teamsIds->get($playerData['team']),
            ]);

            if ($this->option('photos')) {
                $this->downloadPhotos($player, $playerData);
            }

            $this->importedInc();
            $this->advanceProgressBar();
        }
    }

    private function downloadPhotos(Player $player, array $playerData): void
    {
        $localPhotoName = $player->getFilePhotoName();

        $disk = Storage::disk('player-photos');
        if ($disk->exists($localPhotoName)) {
            return;
        }

        $fplPhotoName = Str::of($playerData['photo'])->prepend('p')->replace('jpg', 'png');

        $image = $this->downloadPhotoImg($fplPhotoName);
        if (!$image) {
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

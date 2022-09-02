<?php

namespace App\Console\Commands;

use App\Models\Enums\PlayerPosition;
use App\Models\Player;
use App\Models\Team;
use App\Services\FPL\FPLService;

class ImportPlayersCommand extends FPLImportCommand
{
    public function entityName(): string
    {
        return 'players';
    }

    // TODO: выгружать данные по травмам, фото, status
    // status: a - все ок, i - травма (точно не сыграет), d - повреждение (возможно сыграет), u - ушел (аренда/трансфер)
    public function import(FPLService $FPLService): void
    {
        $data = $FPLService->getBootstrapStatic();
        $playersData = $data['elements'];

        $teamsIds = Team::pluck('id', 'fpl_id');

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

            $this->importedInc();
        }
    }
}

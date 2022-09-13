<?php

namespace App\Console\Commands;

use App\Models\Player;
use App\Models\Team;
use App\Services\FotMob\FotMobService;
use Illuminate\Console\Command;
use Str;

class SyncFotMobPlayersCommand extends Command
{
    protected $signature = 'fot-mob:sync-players';

    protected $description = 'Sync players from fot mob';

    public function handle(FotMobService $fotMobService): void
    {
        Team::query()
            ->with(['players' => fn ($q) => $q->whereNull('fot_mob_id')])
            ->each(function (Team $team) use ($fotMobService) {
                $teamData = $fotMobService->getTeam($team);

                $this->syncTeamPlayers($team, $teamData);
            });
    }

    private function syncTeamPlayers(Team $team, array $teamData): void
    {
        $squad = collect(
            $teamData['details']['sportsTeamJSONLD']['athlete']
        );

        $team->players->each(function (Player $player) use ($squad) {
            if ($fotMobId = $this->fixedPlayersFotMobId($player)) {
                $player->update([
                    'fot_mob_id' => $fotMobId,
                ]);

                return;
            }

            $playerFullName = Str::ascii($player->full_name);
            $playerName = Str::ascii($player->name);
            $squad = $squad->keyBy(fn (array $playerData) => Str::ascii($playerData['name']));

            $playerData = $squad->pull($playerFullName);
            if (! $playerData) {
                $playerData = $squad->pull($playerName);
            }

            if (! $playerData) {
                $playerDataKey = $squad->search(fn (array $playerData, string $playerDataName) => Str::of($playerDataName)->contains($playerName));
                $playerData = $playerDataKey !== false ? $squad->pull($playerDataKey) : null;
            }

            if (! $playerData) {
                $playerDataKey = $squad->search(fn (array $playerData, string $playerDataName) => Str::of($playerFullName)->contains($playerDataName));
                $playerData = $playerDataKey !== false ? $squad->pull($playerDataKey) : null;
            }

            if (! $playerData) {
                return;
            }

            $fotMobId = Str::of($playerData['url'])
                ->replace('https://fotmob.com//players/', '')
                ->before('/');

            $player->update([
                'fot_mob_id' => $fotMobId,
            ]);
        });
    }

    private function fixedPlayersFotMobId(Player $player): ?int
    {
        return [
            9 => 575735,
            17 => 957118,
            20 => 299981,
            22 => 592909,
            34 => 303059,
            91 => 659018,
            541 => 938521,
            514 => 951954,
            181 => 363333,
            205 => 262550,
            219 => 1113816,
            521 => 894805,
            573 => 1288450,
            402 => 212470,
            487 => 933845,
        ][$player->fpl_id] ?? null;
    }
}

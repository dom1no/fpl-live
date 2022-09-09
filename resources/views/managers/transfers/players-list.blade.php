@php
    use App\Models\ManagerPick;
    use App\Models\Player;

    $playerField = $isIn ? 'playerIn' : 'playerOut';
    $players = $manager->transfers->pluck($playerField);
    $mapToPicks = $players->map(function (Player $player) {
        $pick = new ManagerPick([
            'multiplier' => 1,
            'clean_points' => $player->points->sum('points'),
        ]);
        $pick->setRelation('player', $player);

        return $pick;
    });
@endphp

@include('components.picks-list', [
    'picks' => $mapToPicks,
    'sortBy' => 'player.price',
    'showCleanPoints' => true,
    'withTotal' => true,
])

@each('components.player-modal', $players, 'player')

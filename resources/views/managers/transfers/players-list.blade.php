@php
    use App\Models\ManagerPick;
    use App\Models\ManagerTransfer;use App\Models\Player;

    $playerField = $isIn ? 'playerIn' : 'playerOut';
    $players = $manager->transfers->pluck($playerField);
    $mapToPicks = $manager->transfers->map(function (ManagerTransfer $transfer) use ($playerField, $isIn) {
        $player = $transfer->$playerField;
        $cost = $isIn ? $transfer->player_in_cost : $transfer->player_out_cost;

        $pick = new ManagerPick([
            'multiplier' => 1,
            'clean_points' => $player->points->sum('points'),
        ]);
        $player->name .= ' - ' . price_formatted($cost);
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

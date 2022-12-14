@php
    use App\Models\ManagerPick;
    use App\Models\ManagerTransfer;use App\Models\Player;

    $gameweek = request()->gameweek();
    $playerField = $isIn ? 'playerIn' : 'playerOut';
    $players = $manager->transfers->pluck($playerField);
    $mapToPicks = $manager->transfers->map(function (ManagerTransfer $transfer) use ($playerField, $isIn) {
        $player = $transfer->$playerField;
        $cost = $isIn ? $transfer->player_in_cost : $transfer->player_out_cost;

        $pick = new ManagerPick([
            'multiplier' => 1,
            'points' => $player->points->sum('points'),
        ]);
        $player->price = $cost;
        $pick->setRelation('player', $player);

        return $pick;
    });
@endphp

@include('components.picks-list', [
    'picks' => $mapToPicks->sortByDesc('player.price'),
    'sorted' => false,
    'showPrice' => true,
    'withTotal' => true,
])

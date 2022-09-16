@php use App\Models\Enums\ChipType; @endphp

<table class="table align-items-center">
    <thead>
    <tr>
        <th>Ушел</th>
        <th>Пришел</th>
        <th class="d-none d-sm-table-cell">Позиция</th>
    </tr>
    </thead>
    <tbody>
    @foreach($manager->transfers->groupBy('gameweek_id') as $gameweekTransfers)
        @php($gameweek = $gameweekTransfers->first()->gameweek)
        <tr class="font-weight-bold bg-secondary">
            <td colspan="100%" class="py-2">
                {{ $gameweek->name }}

                @include('managers.components.chips-badges', [
                    'chips' => $manager->chips->where('gameweek_id', $gameweek->id)->whereIn('type', [ChipType::WILDCARD, ChipType::FREE_HIT]),
                ])
                <span class="float-right">
                    Платных: {{ $manager->gameweekPointsHistory->paid_transfers_count }}
                </span>
            </td>
        </tr>
        @foreach($gameweekTransfers->sortBy(fn ($transfer) => $transfer->playerOut->position->sortValue()) as $transfer)
            <tr>
                @php($playerOut = $transfer->playerOut)
                <td class="pointer" data-toggle="modal" data-target="#player-{{ $playerOut->id }}">
                    {{ $playerOut->name }}
                    <span class="text-muted text-xs">
                        {{ price_formatted($transfer->player_out_cost) }}
                    </span>
                    <br>
                    <span class="text-muted text-xs">
                        {{ $playerOut->team->name }}
                    </span>
                </td>
                @php($playerIn = $transfer->playerIn)
                <td class="pointer" data-toggle="modal" data-target="#player-{{ $playerIn->id }}">
                    {{ $playerIn->name }}
                    <span class="text-muted text-xs">
                        {{ price_formatted($transfer->player_in_cost) }}
                    </span>
                    <br>
                    <span class="text-muted text-xs">
                        {{ $playerIn->team->name }}
                    </span>
                </td>
                <td class="d-none d-sm-table-cell">
                    {{ $playerOut->position->value }}
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

@each('components.player-modal.index', $manager->transfers->pluck('playerIn')->merge($manager->transfers->pluck('playerOut')), 'player')

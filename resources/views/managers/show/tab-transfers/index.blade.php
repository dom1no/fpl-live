@php use App\Models\Enums\ChipType; @endphp

<table class="table align-items-center">
    <thead>
    <tr>
        <th>Ушел</th>
        <th>Пришел</th>
        <th>Позиция</th>
    </tr>
    </thead>
    <tbody>
    @foreach($manager->transfers->groupBy('gameweek_id') as $gameweekTransfers)
        @php($gameweek = $gameweekTransfers->first()->gameweek)
        <tr class="font-weight-bold bg-secondary">
            <td colspan="2" class="py-2">
                {{ $gameweek->name }}

                @if ($changeSquadChip = $manager->chips->where('gameweek_id', $gameweek->id)->whereIn('type', [ChipType::WILDCARD, ChipType::FREE_HIT])->first())
                    <span class="badge badge-info">
                        {{ $changeSquadChip->type->title() }}
                    </span>
                @endif
            </td>
            <td class="text-right py-2">
                Платных: {{ $manager->gameweekPointsHistory->paid_transfers_count }}
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
                <td>
                    {{ $playerOut->position->value }}
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

@each('components.player-modal.index', $manager->transfers->pluck('playerIn')->merge($manager->transfers->pluck('playerOut')), 'player')

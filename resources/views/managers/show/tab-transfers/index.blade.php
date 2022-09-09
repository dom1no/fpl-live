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
                Платных: {{ $gameweekTransfers->where('is_free', false)->count() }}
            </td>
        </tr>
        @foreach($gameweekTransfers as $transfer)
            <tr>
                <td>
                    @php($playerOut = $transfer->playerOut)
                    {{ $playerOut->name }}
                    <br>
                    <span class="text-muted text-xs">
                        {{ $playerOut->team->name }}
                    </span>
                </td>
                <td>
                    @php($playerIn = $transfer->playerIn)
                    {{ $playerIn->name }}
                    <br>
                    <span class="text-muted text-xs">
                        {{ $playerIn->team->name }}
                    </span>
                </td>
                <td>
                    {{ $playerOut->position->title() }}
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

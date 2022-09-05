<table class="table">
    <thead>
    <tr>
        <th>Ушел</th>
        <th>Пришел</th>
        <th>Позиция</th>
    </tr>
    </thead>
    <tbody>
    @foreach($manager->transfers->groupBy('gameweek_id') as $gameweekTransfers)
        <tr class="font-weight-bold bg-secondary">
            <td colspan="2" class="py-2">{{ $gameweekTransfers->first()->gameweek->name }}</td>
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
                    <span class="text-muted">
                        {{ $playerOut->team->name }}
                    </span>
                </td>
                <td>
                    @php($playerIn = $transfer->playerIn)
                    {{ $playerIn->name }}
                    <br>
                    <span class="text-muted">
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

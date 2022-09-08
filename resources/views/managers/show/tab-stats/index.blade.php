<table class="table">
    <thead>
    <tr class="thead-light">
        <th style="max-width: 45vw;"></th>
        <th>{{ $gameweek->name }}</th>
        <th>Всего</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="max-width: 45vw;">Очки</td>
        <td>
            {{ $manager->gameweekPointsHistory->gameweek_points }}
            @if ($transfersCost = $manager->paid_transfers_count * 4)
                <span class="opacity-7">
                    (-{{ $transfersCost }})
                </span>
            @endif
        </td>
        <td>
            {{ $manager->gameweekPointsHistory->total_points }}
        </td>
    </tr>
    <tr>
        <td style="max-width: 45vw;">Место</td>
        <td>{{ $managerPositions[$gameweek->id] }}</td>
        <td>{{ $managerPositions['total'] }}</td>
    </tr>
    <tr>
        <td style="max-width: 45vw;" class="text-break">Трансферы/платные</td>
        <td>
            @php($gameweekTransfers = $manager->transfers->where('gameweek_id', $gameweek->id))
            {{ $gameweekTransfers->count() }}
            @if ($gameweekTransfers->count())
                / {{ $gameweekTransfers->where('is_free', false)->count() }}
            @endif
        </td>
        <td>
            {{ $manager->transfers->count() }}
            @if ($manager->transfers->count())
                / {{ $manager->transfers->where('is_free', false)->count() }}
            @endif
        </td>
    </tr>
    <tr>
        <td style="max-width: 45vw;">Чипы</td>
        <td>
            @forelse($manager->chips->where('gameweek_id', $gameweek->id) as $chip)
                <span class="badge badge-light mb-1 mb-sm-0">
                    {{ $chip->type->title() }}
                </span>
                @if (!$loop->last)
                    <br class="d-block d-sm-none">
                @endif
            @empty - @endforelse
        </td>
        <td>
            @forelse($manager->chips as $chip)
                <span class="badge badge-light mb-1 mb-sm-0">
                    {{ $chip->type->title() }}
                </span>
                @if (!$loop->last)
                    <br class="d-block d-sm-none">
                @endif
            @empty - @endforelse
        </td>
    </tr>
    <tr>
        <td style="max-width: 45vw;" class="text-break">Сыграло/играет игроков</td>
        <td>
            {{ $playedPicksCount['played'] }}
            @if ($playedPicksCount['playing'])
                / {{ $playedPicksCount['playing'] }}
            @endif
        </td>
        <td>-</td>
    </tr>
    </tbody>
</table>

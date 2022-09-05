<div class="row">
    <h2 class="col-12 col-md-6 text-center">{{ $manager->name }}</h2>
</div>

<div class="row">
    <div class="col-md-6">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ $gameweek->name }}</th>
                    <th>Всего</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Очки</td>
                    <td>
                        {{ $manager->gameweek_points }}
                        @if ($transfersCost = $manager->paid_transfers_count * 4)
                            <span class="opacity-7">
                                (-{{ $transfersCost }})
                            </span>
                        @endif
                    </td>
                    <td>
                        {{ $manager->total_points }}
                    </td>
                </tr>
                <tr>
                    <td>Место</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Чипы</td>
                    <td>
                        @include('managers.components.chips-badges', [
                            'chips' => $manager->chips->where('gameweek_id', $gameweek->id),
                            'emptyValue' => '-',
                        ])
                    </td>
                    <td>
                        @include('managers.components.chips-badges', [
                            'chips' => $manager->chips,
                            'emptyValue' => '-',
                        ])
                    </td>
                </tr>
                <tr>
                    <td>Сыграло(играет) игроков</td>
                    <td>
                        {{ $playedPicksCount['played'] }}
                        @if ($playedPicksCount['playing'])
                            ({{ $playedPicksCount['playing'] }})
                        @endif
                    </td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

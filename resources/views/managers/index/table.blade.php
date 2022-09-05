<table class="table table-hover align-items-center">
    <thead class="thead-light">
    <tr>
        <th scope="col" class="px-3">#</th>
        <th scope="col" class="pl-2">Менеджер</th>
        <th scope="col">Очки</th>
        <th scope="col">Всего</th>
{{--        <th scope="col">Сыграло(играет) игроков</th>--}}
    </tr>
    </thead>
    <tbody>
    @foreach($managers as $manager)
        <tr>
            <td style="width: 20px;" class="px-3">
                {{ $loop->iteration }}
            </td>
            <td class="pl-2">
                <a href="{{ route('managers.show', $manager) }}">
                    {{ $manager->name }}
                </a>
                @include('managers.components.chips-badges', [
                    'chips' => $manager->chips,
                    'withMobileBr' => true,
                ])
            </td>
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
{{--            <td>--}}
{{--                @php($playedPicksCount = $playedPicksCountByManagers->get($manager->id))--}}
{{--                Сыграло(играет) игроков:--}}
{{--                {{ $playedPicksCount['played'] }}--}}
{{--                @if($playedPicksCount['playing'])--}}
{{--                    ({{ $playedPicksCount['playing'] }})--}}
{{--                @endif--}}
{{--            </td>--}}
        </tr>
    @endforeach
    </tbody>
</table>

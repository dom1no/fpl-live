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
        <tr @class(['font-weight-bold bg-light' => auth()->user()->is($manager)])>
            <td style="width: 20px;" class="px-3">
                {{ $loop->iteration }}
            </td>
            <td class="pl-2">
                <a href="{{ route('managers.show', ['manager' => $manager, 'gameweek' => $gameweek->id]) }}">
                    {{ $manager->name }}
                </a>
                @foreach($manager->chips as $chip)
                    <br class="d-block d-sm-none">
                    <span class="badge badge-light mt-1 mt-sm-0">
                        {{ $chip->type->title() }}
                    </span>
                @endforeach
            </td>
            <td>
                {{ $manager->gameweekPointsHistory->points }}
                @if ($transfersCost = $manager->gameweekPointsHistory->transfers_cost)
                    <span class="opacity-7">
                        (-{{ $transfersCost }})
                    </span>
                @endif
            </td>
            <td>
                {{ $manager->gameweekPointsHistory->total_points }}
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

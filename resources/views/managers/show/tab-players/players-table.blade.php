<table class="table align-items-center">
    <thead class="thead-light">
    <tr>
        <th scope="col">Игрок</th>
        <th scope="col">Очки</th>
        <th scope="col" class="d-none d-md-flex">Матч</th>
        <th scope="col">Цена</th>
        {{--            <th scope="col">Очки на 1£</th>--}}
    </tr>
    </thead>
    <tbody>

    @foreach($mainPicks->groupBy('player.position.value') as $picks)
        <tr class="opacity-8">
            <td colspan="100%" class="py-2">
                {{ $picks->first()->player->position->title() }}
            </td>
        </tr>
        @foreach($picks as $pick)
            @include('managers.show.tab-players.players-table-row')
        @endforeach
    @endforeach

    <tr>
        <td colspan="100%" class="text-left">Запас</td>
    </tr>
    @foreach($benchPicks as $pick)
        @include('managers.show.tab-players.players-table-row', [
            'showPosition' => true,
            'showCleanPoints' => true,
        ])
    @endforeach
    </tbody>
</table>

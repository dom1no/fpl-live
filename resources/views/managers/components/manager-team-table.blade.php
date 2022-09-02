<div class="table-responsive">
    <table class="table align-items-center">
        <thead class="thead-light">
        <tr>
            <th scope="col">Игрок</th>
            <th scope="col">GW Очки</th>
            <th scope="col">Матч</th>
            <th scope="col">Цена</th>
            <th scope="col">Очки на 1£</th>
        </tr>
        </thead>
        <tbody>

        @php([$mainPicks, $benchPicks] = $manager->picks->partition(fn ($pick) => $pick->position <= 11))

        @foreach($mainPicks->groupBy('player.position.value') as $picks)
            <tr class="opacity-8">
                <td colspan="5" class="py-2">
                    {{ $picks->first()->player->position->title() }}
                </td>
            </tr>
            @foreach($picks as $pick)
                @include('managers.components.manager-team-pick-row')
            @endforeach
        @endforeach

        <tr>
            <td colspan="5" class="text-left">Запас</td>
        </tr>
        @foreach($benchPicks as $pick)
            @include('managers.components.manager-team-pick-row', [
                'showPosition' => true,
                'showCleanPoints' => true,
            ])
        @endforeach
        </tbody>
    </table>
</div>

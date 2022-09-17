<div class="table-responsive">
    <table class="table align-items-center">
        <thead class="thead-light">
        <tr>
            <th scope="col" class="px-3">#</th>
            <th scope="col" class="pl-2">Менеджер</th>
            <th scope="col">Очки</th>
            <th scope="col">Всего</th>
            <th scope="col" data-toggle="tooltip" data-placement="top" title="Сыграло/играет игроков">
                @svg('jam-check')@svg('jam-play')
            </th>
            <th scope="col" class="text-center" data-toggle="tooltip" data-placement="top" title="Стоимость основы/всего">
                @svg('phosphor-currency-gbp-bold')
            </th>
            <th colspan="1" class="border">Вратарь</th>
            <th colspan="5" class="border">Защита</th>
            <th colspan="5" class="border">Полузащита</th>
            <th colspan="3" class="border">Нападение</th>
            <th colspan="4" class="border">Запас</th>
        </tr>
        </thead>
        <tbody>
        @php
            $me = $managers->firstWhere('id', auth()->id());
            $myPicks = $me->picks;
        @endphp

        @foreach($managers as $manager)
            <tr @class([
                'manager-row',
                'bg-light' => $manager->is($me),
            ])>
                <td style="width: 20px;" class="px-3">
                    {{ $loop->iteration }}
                </td>
                <td class="pl-2">
                    <a href="{{ route('managers.show', $manager) }}">
                        {{ $manager->name }}
                    </a>
                    @include('managers.components.chips-badges', ['chips' => $manager->chips, 'withMobileBr' => true])
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
                <td>
                    @php
                        $playedPicksCount = $playedPicksCountByManagers->get($manager->id);
                    @endphp

                    {{ $playedPicksCount['played'] }}
                    @if ($playedPicksCount['playing'])
                        / {{ $playedPicksCount['playing'] }}
                    @endif
                </td>
                <td>
                    {{ price_formatted($manager->picks->where('position', '<=', '11')->sum('player.price')) }}
                    /
                    {{ price_formatted($manager->picks->sum('player.price')) }}
                </td>
                @php
                    [$mainPicks, $benchPicks] = $manager->picks->partition('position', '<=', 11);
                @endphp

                @foreach($mainPicks->groupBy('player.position.value') as $positionPicks)
                    @foreach($positionPicks->sortBy('player_id')->sortByDesc('player.price') as $pick)
                        @php
                            $player = $pick->player;
                            $fixture = $player->team->fixtures->first() ?: optional();
                        @endphp

                        <td
                            data-player-id="{{ $pick->player_id }}"
                            @class([
                                'pick-cell',
                                'border-left' => $loop->first,
                                'font-weight-bold' => $fixture->isFinished(),
                                'bg-lighter' => $manager->isNot($me) && $myPicks->contains('player_id', $pick->player_id),
                            ])>
                            {{ $player->name }}
                            @include('managers.components.pick-points')
                            @if ($pick->is_captain)
                                <i class="fas fa-copyright"></i>
                            @endif
                            <br>
                            <span class="font-weight-normal opacity-6">
                                {{ $player->team->name }}
                            </span>
                        </td>

                        @if (!$loop->parent->first && $loop->last && $emptySlots = $pick->player->position->playersCountInTeam() - $loop->iteration)
                            @for ($i = 0; $i < $emptySlots; $i++)
                                <td class="pick-cell">-</td>
                            @endfor
                        @endif
                    @endforeach
                @endforeach

                @foreach($benchPicks as $pick)
                    @php
                        $player = $pick->player;
                        $fixture = $player->team->fixtures->first() ?: optional();
                    @endphp

                    <td
                        data-player-id="{{ $pick->player_id }}"
                        @class([
                            'pick-cell',
                            'border-left' => $loop->first,
                            'font-weight-bold' => $fixture->isFinished(),
                            'bg-lighter' => $manager->isNot($me) && $myPicks->contains('player_id', $pick->player_id),
                        ])>
                        {{ $player->name }}
                        @include('managers.components.pick-points', ['showCleanPoints' => true])
                        <br>
                        <span class="font-weight-normal opacity-6">
                            {{ $player->team->name }}
                        </span>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.pick-cell[data-player-id]').click(function (e) {
                el = $(e.currentTarget);
                let playerId = el.attr('data-player-id');

                $('td.pick-cell').removeClass('bg-lighter').addClass('bg-white');
                $(`td[data-player-id="${playerId}"]`).addClass('bg-lighter');
            })
        });
    </script>
@endpush

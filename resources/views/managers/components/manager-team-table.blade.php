<div class="table-responsive">
    <table class="table align-items-center">
        <thead class="thead-light">
        <tr>
            <th scope="col">Игрок</th>
            <th scope="col">GW Очки</th>
            <th scope="col">Цена</th>
            <th scope="col">Матч</th>
            <th scope="col">Очки на 1£</th>
        </tr>
        </thead>
        <tbody>
        @foreach($manager->picks as $pick)
            @php($player = $pick->player)
            @php($fixture = $player->team->fixtures->first())
            <tr class="@if($fixture->isFinished())font-weight-bold @endif">
                <td>
                    {{ $player->name }}
                    @if ($pick->is_captain)
                        <i class="fas fa-copyright"></i>
                    @endif
                    <br>
                    <span class="opacity-7">
                        {{ $player->team->short_name }} {{ $player->position->value }}
                    </span>
                </td>
                <td>
                    @if ($pick->multiplier > 0 && ($pick->points > 0 || !$fixture->isFeature()))
                        {{ $pick->points }}
                        @if ($pick->clean_points >= 10)
                            <i class="fas fa-angle-double-up text-success"></i>
                        @elseif ($pick->clean_points >= 7)
                            <i class="fas fa-angle-up text-success"></i>
                        @elseif ($pick->clean_points >= 3)
                            <i class="fas fa-angle-up text-primary"></i>
                        @elseif ($pick->clean_points >= 0)
                            <i class="fas fa-minus text-warning"></i>
                        @else
                            <i class="fas fa-angle-double-down text-danger"></i>
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td>
                    {{ price_formatted($player->price) }}
                </td>
                <td>
                    <a href="{{ route('fixtures.show', $fixture) }}">
                        {{ $fixture->homeTeam->name }}
                        @if ($fixture->isFeature())
                            -
                        @else
                            {{ $fixture->homeTeam->pivot->score }}:{{ $fixture->awayTeam->pivot->score }}
                        @endif
                        {{ $fixture->awayTeam->name }}
                    </a>
                </td>
                <td>
                    {{ round($pick->points / $player->price, 1) }}
                </td>
            </tr>
            @if ($loop->iteration === 11)
                <tr>
                    <td colspan="5" class="text-left lead">Запас</td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

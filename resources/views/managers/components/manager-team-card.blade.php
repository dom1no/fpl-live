<div class="card m-2">
    <div class="card-header">
        <h2>{{ $manager->name }}</h2>
        <p>GW очки: {{ $manager->picks->sum('points') }}</p>
        <p>Всего очков: {{ $manager->total_points }}</p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-items-center">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Игрок</th>
                    <th scope="col">GW Очки</th>
                    <th scope="col">Цена</th>
                </tr>
                </thead>
                <tbody>
                @foreach($manager->picks as $pick)
                    @php($player = $pick->player)
                    <tr>
                        <td>
                            {{ $player->name }}
                            @if ($pick->is_captain)
                                <i class="fas fa-copyright"></i>
                            @endif
                            <br>
                            {{ $player->team->short_name }} {{ $player->position->value }}
                        </td>
                        <td>
                            {{ $pick->points }}
                            @if ($pick->points >= 10)
                                <i class="fas fa-angle-double-up text-success"></i>
                            @elseif ($pick->points >= 7)
                                <i class="fas fa-angle-up text-success"></i>
                            @elseif ($pick->points >= 3)
                                <i class="fas fa-angle-up text-warning"></i>
                            @elseif ($pick->points >= 0)
                                <i class="fas fa-minus text-warning"></i>
                            @else
                                <i class="fas fa-angle-double-down text-danger"></i>
                            @endif
                        </td>
                        <td>
                            {{ $player->price }}
                        </td>
                    </tr>
                    @if ($loop->iteration === 11)
                        <tr>
                            <td colspan="3" class="text-left lead">Запас</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

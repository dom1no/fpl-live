@php use App\Models\PlayerPoint; @endphp
<div style="max-height: 45vh; overflow-y: auto;">
    <table class="table bg-secondary mb-0">
        <tbody>
        @foreach($fixtures->sortByDesc('gameweek_id') as $fixture)
            @php
                $points = $player->points->where('gameweek_id', $fixture->gameweek_id);
            @endphp
            <tr @class(['font-weight-bold' => $fixture->isFinished(), 'bg-light focused' => $fixture->is($currentFixture)])>
                <td data-toggle="collapse" data-target="#player-{{ $player->id }}-modal-fixture-{{ $fixture->id }}"
                    class="pointer">
                    <span>{{ $fixture->gameweek->name }}</span>
                    <span class="fixture-title-centered m--2">
                        @include('fixtures.components.fixture-title')
                    </span>
                    <span class="text-right font-weight-bold">
                        {{ $points->sum('points') }}
                    </span>
                </td>
            </tr>
            <tr @class(['collapse', 'bg-white', 'show' => $fixture->is($currentFixture)]) id="player-{{ $player->id }}-modal-fixture-{{ $fixture->id }}">
                <td class="p-0">
                    <table class="table bg-white align-items-center m-0">
                        <thead class="thead-light py-1">
                        <tr>
                            <th scope="col" class="py-2">Действие</th>
                            <th scope="col" class="py-2 px-1 px-md-4">Результат</th>
                            <th scope="col" class="py-2 pl-1 pl-md-4">Очки</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($points->sortBy(fn(PlayerPoint $point) => $point->action->sortValue()) as $point)
                            <tr>
                                <td>{{ $point->action->title() }}</td>
                                <td class="px-1 px-md-4">{{ $point->value }}</td>
                                <td class="pl-1 pl-md-4">{{ $point->points }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

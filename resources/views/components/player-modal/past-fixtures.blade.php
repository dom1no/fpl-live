@php use App\Models\PlayerPoint; @endphp
<div style="max-height: 45vh; overflow-y: auto;">
    <table class="table mb-0 player-fixtures-table">
        <tbody>
        @foreach($fixtures->sortByDesc('gameweek_id') as $fixture)
            @php
                $points = $player->points->where('gameweek_id', $fixture->gameweek_id);
                $stats = $player->stats->firstWhere('gameweek_id', $fixture->gameweek_id) ?: optional();
            @endphp
            <tr @class(['pointer', 'fixture-row', 'font-weight-bold' => $fixture->isFinished(), 'focused bg-translucent-success' => $fixture->is($currentFixture)])
                data-toggle="collapse" data-target="#player-{{ $player->id }}-modal-fixture-{{ $fixture->id }}"
            >
                <td>
                    <span>{{ $fixture->gameweek->name }}</span>
                    <span class="fixture-title-centered m--2">
                        @include('fixtures.components.fixture-title')
                    </span>
                    <span class="text-right font-weight-bold">
                        {{ $points->sum('points') }}
                    </span>
                </td>
            </tr>
            <tr @class(['collapse', 'fixture-collapse', 'show' => $fixture->is($currentFixture)]) id="player-{{ $player->id }}-modal-fixture-{{ $fixture->id }}">
                <td class="p-0">
                    @if ($stats->minutes > 0)
                        <table class="table bg-white m-0">
                            @if ($rating = $stats->fot_mob_rating)
                                <tr>
                                    <td class="py-2">Рейтинг</td>
                                    <td class="py-2 text-left">{{ double_formatted($rating) }}</td>
                                </tr>
                            @endif
                            @if ($xG = $stats->xg)
                                <tr>
                                    <td class="py-2">xG</td>
                                    <td class="py-2 text-left">{{ double_formatted($xG) }}</td>
                                </tr>
                            @endif
                            @if ($xA = $stats->xa)
                                <tr>
                                    <td class="py-2">xA</td>
                                    <td class="py-2 text-left">{{ double_formatted($xA) }}</td>
                                </tr>
                            @endif
                        </table>
                    @endif
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

<script type="text/javascript">
    $(document).ready(() => {
        $('.fixture-collapse').on('show.bs.collapse', e => {
            let target = $(e.target);
            $(`.fixture-row[data-target="#${target.attr('id')}"]`).addClass('bg-translucent-success');
        });

        $('.fixture-collapse').on('hidden.bs.collapse', e => {
            let target = $(e.target);
            $(`.fixture-row[data-target="#${target.attr('id')}"]`).removeClass('bg-translucent-success');
        });
    });
</script>

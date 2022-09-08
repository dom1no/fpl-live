@php
    $fixtures = $manager->picks->pluck('player.team.fixtures.0', 'id')->unique();
    $picksByFixture = $manager->picks->groupBy('player.team.fixtures.0.id');
@endphp

<table class="table">
    <tbody>
    @foreach($fixtures as $fixture)
        @php
            $fixturePicks = $picksByFixture->get($fixture->id)->sortByDesc('points');
            $homeTeamPicks = $fixturePicks->where('player.team_id', $fixture->homeTeam->id);
            $awayTeamPicks = $fixturePicks->where('player.team_id', $fixture->awayTeam->id);
        @endphp

        <tr>
            <td colspan="100%" class="p-0">
                <table class="table">
                    <thead
                        @class(['thead-light', 'text-center', 'font-weight-bold' => $fixture->isFinished()])
                    >
                    <tr>
                        <th colspan="100%" class="clickable">
                            <a href="{{ route('fixtures.show', $fixture) }}" class="">
                                {{ $fixture->kickoff_time->format('d.m H:i') }}
                                <br>
                                <span class="small">{{ $fixture->status_text }}</span>
                            </a>
                        </th>
                    </tr>
                    <tr>
                        <th class="w-50 border-right">
                            {{ $fixture->homeTeam->name }}
                            <span class="float-right">{{ $fixture->homeTeam->pivot->score }}</span>
                        </th>
                        <th class="w-50">
                            <span class="float-left">{{ $fixture->awayTeam->pivot->score }}</span>
                            {{ $fixture->awayTeam->name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    <tr>
                        <td class="w-50 border-right">
                            <dl class="row mb-0">
                                @foreach($homeTeamPicks as $pick)
                                    <dd class="font-weight-normal text-right col-9 col-sm-10 col-md-11">
                                        {{ $pick->player->name }}
                                        @if ($pick->is_captain)
                                            <i class="fas fa-copyright"></i>
                                        @endif
                                    </dd>
                                    <dt class="font-weight-bold col-3 col-sm-2 col-md-1">
                                        {{ $pick->points }}
                                    </dt>
                                @endforeach
                            </dl>
                        </td>
                        <td class="w-50">
                            <dl class="row mb-0">
                                @foreach($awayTeamPicks as $pick)
                                    <dt class="col-3 col-sm-2 col-md-1">
                                        {{ $pick->points }}
                                    </dt>
                                    <dd class="col-9 col-sm-10 col-md-11">
                                        {{ $pick->player->name }}
                                        @if ($pick->is_captain)
                                            <i class="fas fa-copyright"></i>
                                        @endif
                                    </dd>
                                @endforeach
                            </dl>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

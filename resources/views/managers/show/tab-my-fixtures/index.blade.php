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
                @include('managers.show.tab-my-fixtures.fixture')
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

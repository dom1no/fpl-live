@php
    use App\Models\ManagerPick;
    $fixtures = $manager->picks->mapWithKeys(fn (ManagerPick $pick) => [$pick->id => $pick->player->team->fixtures->firstWhere('gameweek_id', $gameweek->id)])->unique('id')->filter();
    $picksByFixture = $manager->picks->groupBy(fn (ManagerPick $pick) => $pick->player->team->fixtures->firstWhere('gameweek_id', $gameweek->id)->id ?? null);
@endphp

<table class="table">
    <tbody>
    @foreach($fixtures->sortBy('kickoff_time') as $fixture)
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

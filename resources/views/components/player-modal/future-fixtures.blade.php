<table class="table bg-secondary">
    <tbody>
    @foreach($fixtures->sortBy('gameweek_id') as $fixture)
        <tr>
            <td>
                <span class="d-inline-block" style="min-width: 40px;">{{ $fixture->gameweek->name }}</span>
                <span class="fixture-title-centered m--4 m-md--2">
                    @include('fixtures.components.fixture-title')
                </span>
                <span class="d-inline-block text-right m--1 m-md--3 text-xs">
                    {{ $fixture->kickoff_time->format('d.m H:i') }}
                </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

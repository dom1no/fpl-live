<div style="max-height: 45vh; overflow-y: auto;">
    <table class="table mb-0">
        <tbody>
        @foreach($fixtures->sortBy('gameweek_id') as $fixture)
            <tr @class(['bg-translucent-success focused' => $fixture->is($currentFixture)])>
                <td class="clickable">
                    <a href="{{ route('fixtures.show', $fixture) }}" class="px-3 text-body text-decoration-none">
                        <span class="d-inline-block" style="min-width: 40px;">{{ $fixture->gameweek->name }}</span>
                        <span class="fixture-title-centered m--4 m-md--2">
                            @include('fixtures.components.fixture-title')
                        </span>
                        <span class="d-inline-block text-right m--1 m-md--3 text-xs">
                            {{ $fixture->kickoff_time->format('d.m H:i') }}
                        </span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

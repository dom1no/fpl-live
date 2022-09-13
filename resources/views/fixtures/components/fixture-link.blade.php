@if ($fixture->exists)
    @php
        $homeTeam = $fixture->homeTeam;
        $awayTeam = $fixture->awayTeam;
    @endphp

    <a href="{{ route('fixtures.show', $fixture) }}" @class([$linkClass ?? null])>
        @include('fixtures.components.fixture-title')
    </a>
@endif

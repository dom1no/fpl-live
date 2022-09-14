@if ($fixture && $fixture->exists)
    <a href="{{ route('fixtures.show', $fixture) }}" @class([$linkClass ?? null])>
        @include('fixtures.components.fixture-title')
    </a>
@endif

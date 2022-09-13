<div class="col-sm text-center px-1">
    <span class="text-muted text-sm">{{ $fixture->kickoff_time->format('d.m.Y H:i') }}</span>

    <br>
    <div class="display-3 fixture-title-centered text-autosize-container">
        @include('fixtures.components.fixture-title')
    </div>

    @if (!$fixture->isFeature())
        <span class="d-block text-muted text-xs">
            {{ $fixture->xg_formatted }}
        </span>
   @endif

    @if (!$fixture->isFeature())
        <span class="text-sm">
            {{ $fixture->status_text }}
        </span>
    @endif
</div>

@include('components.scripts.text-autosize')

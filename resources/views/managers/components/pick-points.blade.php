@if ($pick->points > 0 || !$fixture->isFeature())
    @if ($showCleanPoints ?? false)
        <span class="opacity-8">{{ $pick->clean_points }}</span>
    @else
        {{ $pick->points }}
    @endif

    @if ($showIcon ?? true)
        @svg($pick->getIconByPoints(), [
            'class' => 'text-' . $pick->getColorClassByPoints(),
            'width' => '16px',
        ])
    @endif
@else
    -
@endif

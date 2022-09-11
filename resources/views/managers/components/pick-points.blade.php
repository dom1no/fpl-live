@if ($pick->points > 0 || !$fixture->isFeature())
    @if ($showCleanPoints ?? false)
        <span class="opacity-8">{{ $pick->clean_points ?: 0 }}</span>
    @else
        {{ $pick->points ?: 0 }}
    @endif

    @if ($showIcon ?? true)
        @svg($pick->getIconByPoints(), [
            'class' => 'text-' . $pick->getColorClassByPoints(),
            'width' => '16px',
            'style' => 'padding-bottom: 1px;',
        ])
    @endif
@else
    -
@endif

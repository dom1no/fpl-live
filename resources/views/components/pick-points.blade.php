@if ($pick->points > 0 || !$fixture->isFeature())
    @if ($showCleanPoints ?? false)
        <span class="opacity-8">{{ $pick->clean_points }}</span>
    @else
        {{ $pick->points }}
    @endif
    @if ($pick->clean_points >= 10)
        <i class="fas fa-angle-double-up text-success"></i>
    @elseif ($pick->clean_points >= 7)
        <i class="fas fa-angle-up text-success"></i>
    @elseif ($pick->clean_points >= 3)
        <i class="fas fa-angle-up text-primary"></i>
    @elseif ($pick->clean_points >= 0)
        <i class="fas fa-minus text-warning"></i>
    @else
        <i class="fas fa-angle-double-down text-danger"></i>
    @endif
@else
    -
@endif

@php
    $colorClass = match (true) {
        $gameweek->is_current && !$gameweek->is_finished => 'success',
        $gameweek->is_current && $gameweek->is_finished => 'dark text-capitalize',
        $gameweek->isFeature() => 'primary',
        default => 'dark',
    };
    $title = match (true) {
        $gameweek->is_current && !$gameweek->is_finished => 'Live',
        $gameweek->is_current && $gameweek->is_finished => 'Завершен',
        default => $gameweek->deadline_at->format('d.m H:i'),
    };
@endphp

<span class="d-inline-block badge badge-pill badge-{{ $colorClass }} {{ $class ?? '' }} py-1">
    {{ $title }}
</span>

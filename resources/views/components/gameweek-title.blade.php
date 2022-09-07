@php
    $previousGameweekId = $gameweek->previousId();
    $nextGameweekId = $gameweek->nextId($canViewFeature ?? false);
@endphp

<div class="d-flex justify-content-between align-items-center mb-2 mb-md-3">
    <a href="{{ $previousGameweekId ? request()->fullUrlWithQuery(['gameweek' => $previousGameweekId]) : '#' }}"
       @class(['btn', 'btn-secondary', 'bg-white', 'disabled' => !$previousGameweekId])>
        @svg('jam-arrow-left')
        <span class="d-none d-sm-inline-block">Предыдущий</span>
    </a>

    <div class="display-3 text-center">
        {{ $gameweek->name }}
    </div>

    <a href="{{ $nextGameweekId ? request()->fullUrlWithQuery(['gameweek' => $nextGameweekId]) : '#' }}"
        @class(['btn', 'btn-secondary', 'bg-white', 'disabled' => !$nextGameweekId])>
        <span class="d-none d-sm-inline-block">Следующий</span>
        @svg('jam-arrow-right')
    </a>
</div>

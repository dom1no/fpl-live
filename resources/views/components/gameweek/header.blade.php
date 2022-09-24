@php /** @see \App\View\Composers\GameweekHeaderComposer */ @endphp

<div class="d-flex justify-content-between align-items-center mb-2 mb-md-3">
    <a href="{{ $gameweekUrl($previousId) ?: '#' }}"
        @class(['btn', 'btn-secondary', 'bg-white', 'disabled' => !$previousId])>
        @svg('jam-arrow-left')
        <span class="d-none d-sm-inline-block">Предыдущий</span>
    </a>

    <div class="dropdown">
        <div class="text-center pointer" data-toggle="dropdown">
            <span class="display-3">
                {{ $currentGameweek->name }}
            </span>
            @include('components.gameweek.badge', ['gameweek' => $currentGameweek])
        </div>
        <div class="dropdown-menu" style="max-height: 40vh; overflow-y: auto;">
            @foreach($gameweeks as $gameweek)
                <a class="dropdown-item" href="{{ $gameweekUrl($gameweek->id) }}">
                    {{ $gameweek->name }}
                    @include('components.gameweek.badge', ['class' => 'float-right'])
                </a>
            @endforeach
        </div>
    </div>

    <a href="{{ $gameweekUrl($nextId) }}"
        @class(['btn', 'btn-secondary', 'bg-white', 'disabled' => !$nextId])>
        <span class="d-none d-sm-inline-block">Следующий</span>
        @svg('jam-arrow-right')
    </a>
</div>

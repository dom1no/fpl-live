@php
    use App\Models\Gameweek;
    $currentGameweek = $gameweek ?? Gameweek::getCurrent();
    $gameweeks = Gameweek::query()->orderBy('id')->get();
    $previousId = $gameweeks->sortByDesc('id')->firstWhere('id', '<', $currentGameweek->id)->id ?? null;
    $nextId = $gameweeks->sortBy('id')->firstWhere('id', '>', $currentGameweek->id)->id ?? null;
@endphp

<div class="d-flex justify-content-between align-items-center mb-2 mb-md-3">
    <a href="{{ $previousId ? request()->fullUrlWithQuery(['gameweek' => $previousId]) : '#' }}"
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
                <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['gameweek' => $gameweek->id]) }}">
                    {{ $gameweek->name }}
                    @include('components.gameweek.badge', ['class' => 'float-right'])
                </a>
            @endforeach
        </div>
    </div>

    <a href="{{ $nextId ? request()->fullUrlWithQuery(['gameweek' => $nextId]) : '#' }}"
        @class(['btn', 'btn-secondary', 'bg-white', 'disabled' => !$nextId])>
        <span class="d-none d-sm-inline-block">Следующий</span>
        @svg('jam-arrow-right')
    </a>
</div>

<div class="card fixture-team-card">
    <div class="card-header">
        <h2>{{ $team->name }}</h2>
    </div>
    <div class="card-body p-0">
        @if($fixture->isFeature())
            @include('fixtures.components.team-players-list')
        @else
            @include('fixtures.components.team-players-list', [
                'players' => $players->where('gameweekStats.minutes', '>', 0)
            ])
            <h3>
                <button class="btn btn-link w-100 text-primary text-left" type="button"
                        data-toggle="collapse"
                        data-target="#collapse-bench-team-{{ $team->id }}"
                        aria-expanded="false"
                        aria-controls="collapseExample">
                    Запас
                    <i class="ni ni-bold-down"></i>
                </button>
            </h3>
            <div class="collapse" id="collapse-bench-team-{{ $team->id }}">
                @include('fixtures.components.team-players-list', [
                    'players' => $players->where('gameweekStats.minutes', 0)
                ])
            </div>
        @endif
    </div>
</div>

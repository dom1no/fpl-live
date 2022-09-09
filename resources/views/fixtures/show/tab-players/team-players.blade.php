<div class="card fixture-team-card shadow">
    <div class="card-header">
        <h2>{{ $team->name }}</h2>
    </div>

    <div class="card-body p-0">
        @if ($fixture->isFeature())
            @include('fixtures.show.tab-players.team-players-table')
        @else
            @include('fixtures.show.tab-players.team-players-table', [
                'players' => $players->where('gameweekStats.minutes', '>', 0)
            ])

            <h3>
                <button class="btn btn-link w-100 text-primary text-left" type="button"
                        data-toggle="collapse"
                        data-target="#collapse-bench-team-{{ $team->id }}"
                        aria-expanded="false"
                        aria-controls="collapseExample">
                    Не играли
                    <i class="ni ni-bold-down"></i>
                </button>
            </h3>
            <div class="collapse" id="collapse-bench-team-{{ $team->id }}">
                @include('fixtures.show.tab-players.team-players-table', [
                    'players' => $players->where('gameweekStats.minutes', 0)
                ])
            </div>
        @endif
    </div>
</div>

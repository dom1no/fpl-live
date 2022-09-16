<div class="card fixture-team-card shadow">
    <div class="card-header">
        <h2>{{ $team->name }}</h2>
    </div>

    <div class="card-body p-0">
        @if ($fixture->isFeature())
            @include('fixtures.show.tab-players.team-players-table')
        @else
            @php
                [$playedPlayers, $notPlayerPlayers] = $players->partition('gameweekStats.minutes', '>', 0);
                [$benchPlayer, $notAvailablePlayers] = $notPlayerPlayers->partition('gameweekStats.is_bench', true);
            @endphp
            @include('fixtures.show.tab-players.team-players-table', [
                'players' => $playedPlayers,
            ])

            <hr class="mt-0 mb-2">
            <h3>
                <button class="btn btn-link w-100 text-primary text-left" type="button"
                        data-toggle="collapse"
                        data-target="#collapse-bench-team-{{ $team->id }}">
                    Запас
                    <i class="ni ni-bold-down"></i>
                </button>
            </h3>
            <div class="collapse" id="collapse-bench-team-{{ $team->id }}">
                @include('fixtures.show.tab-players.team-players-table', [
                    'players' => $benchPlayer->sortByDesc('price'),
                ])
            </div>

            <hr class="my-0">
            <h3>
                <button class="btn btn-link w-100 text-primary text-left" type="button"
                        data-toggle="collapse"
                        data-target="#collapse-not-available-team-{{ $team->id }}">
                    Вне заявки
                    <i class="ni ni-bold-down"></i>
                </button>
            </h3>
            <div class="collapse" id="collapse-not-available-team-{{ $team->id }}">
                @include('fixtures.show.tab-players.team-players-table', [
                    'players' => $notAvailablePlayers->sortBy('chance_of_playing'),
                ])
            </div>
        @endif
    </div>
</div>

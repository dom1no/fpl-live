<div class="card m-2">
    <div class="card-header">
        <h2>{{ $manager->name }}</h2>
        <span>
            GW очки: {{ $manager->picks->sum('points') }}
            <br>
            Всего очков: {{ $manager->total_points }}
            <br><br>

            @php($playedPicks = $playedPicksByManagers->get($manager->id))
            @php($playedPicksMain = $playedPicks->where('multiplier', '>', 0))
            Сыграло игроков: {{ $playedPicksMain->count() }} ({{ $playedPicks->count() }})
            | {{ price_formatted($playedPicksMain->sum('player.price')) }} ({{ price_formatted($playedPicks->sum('player.price')) }})
        </span>
    </div>
    <div class="card-body">
        @include('managers.components.manager-team-table')
    </div>
</div>

<div class="card m-2">
    <div class="card-header">
        <h2>{{ $manager->name }}</h2>
        <span>
            GW очки: {{ $manager->picks->sum('points') }}
            @if ($transfersCost = $manager->paid_transfers_count * 4)
                <span class="opacity-7">
                    (-{{ $transfersCost }})
                </span>
            @endif
            <br>
            Всего очков: {{ $manager->total_points }}
            @php($livePoints = $manager->total_picks_points - ($manager->total_paid_transfers_count * 4))
            @if ($livePoints != $manager->total_points)
                ({{ $livePoints }})
            @endif
            <br><br>

            @php($playedPicks = $playedPicksByManagers->get($manager->id))
            @php($playedPicksMain = $playedPicks->where('multiplier', '>', 0))
            Сыграло игроков: {{ $playedPicksMain->count() }} ({{ $playedPicks->count() }})
            | {{ price_formatted($playedPicksMain->sum('player.price')) }} ({{ price_formatted($playedPicks->sum('player.price')) }})
        </span>
    </div>
    <div class="card-body p-0">
        @include('managers.components.manager-team-table')
    </div>
</div>

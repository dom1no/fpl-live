<h2>{{ $manager->name }}</h2>

<dl class="row">
    <dt class="col-6 col-md-2 text-right">Очки в туре:</dt>
    <dd class="col-6 col-md-10">
        {{ $manager->gameweek_points }}
        @if ($transfersCost = $manager->paid_transfers_count * 4)
            <span class="opacity-7">
            (-{{ $transfersCost }})
        </span>
        @endif
    </dd>

    <dt class="col-6 col-md-2 text-right">Всего очков:</dt>
    <dd class="col-6 col-md-10">
        {{ $manager->total_points }}
    </dd>

    <dt class="col-6 col-md-2 text-right">Сыграло(играет) игроков:</dt>
    <dd class="col-6 col-md-10">
        {{ $playedPicksCount['played'] }}
        @if ($playedPicksCount['playing'])
            ({{ $playedPicksCount['playing'] }})
        @endif
    </dd>
</dl>

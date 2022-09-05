<h2>{{ $manager->name }}</h2>

<span>
    Тур: {{ $manager->gameweek_points }}
    @if ($transfersCost = $manager->paid_transfers_count * 4)
        <span class="opacity-7">
            (-{{ $transfersCost }})
        </span>
    @endif

    <br>
    Всего очков: {{ $manager->total_points }}

    <br><br>
    Сыграло(играет) игроков: {{ $playedPicksCount['played'] }}
    @if($playedPicksCount['playing'])
        ({{ $playedPicksCount['playing'] }})
    @endif
</span>

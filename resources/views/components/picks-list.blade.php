@php
    $totalPoints = 0;
@endphp

<ul @class(['picks-list', 'rtl' => $rtl ?? false])>
    @foreach($picks->sortByDesc($sortBy ?? 'points') as $pick)
        @php
            $player = $pick->player;
            $points = ($showCleanPoints ?? false) ? $pick->clean_points : $pick->points;
            $totalPoints += $points;
        @endphp

        <li @class(['pointer', 'text-light' => $pick->multiplier == 0]) data-toggle="modal" data-target="#player-{{ $player->id }}">
            <span class="picks-list-points">
                {{ $points }}
            </span>
            <span>
                {{ $player->name }}

                @if ($pick->is_captain)
                    <i class="fas fa-copyright"></i>
                @endif
            </span>
        </li>
    @endforeach

    @if (($withTotal ?? false) && $picks->isNotEmpty())
        <li><hr class="my-2"></li>
        <li class="font-weight-bold">
            <span class="picks-list-points">{{ $totalPoints }}</span>
            <span>Всего</span>
        </li>
    @endif
</ul>

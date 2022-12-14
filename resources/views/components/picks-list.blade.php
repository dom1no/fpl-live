@php
    $totalPoints = 0;
    if ($sorted ?? true) {
        [$mainPicks, $benchPicks] = $picks->partition('multiplier', '>', 0);
        $picks = $mainPicks->sortByDesc('points')->merge(
            $benchPicks->sortByDesc('clean_points')
        );
    }
@endphp

<ul @class(['picks-list', 'rtl' => $rtl ?? false])>
    @foreach($picks as $pick)
        @php
            $player = $pick->player;
            $points = $pick->multiplier == 0 ? $pick->clean_points : $pick->points;
            $totalPoints += $points;
        @endphp

        <li @class(['pointer', 'text-light' => $pick->multiplier == 0])
            onclick='Livewire.emitTo("player-modal", "show", @json(["player" => $player->id]))'
        >
            <span class="picks-list-points">
                {{ $points }}
            </span>
            <span>
                {{ $player->name }}

                @include('components.player-status-icon', ['class' => 'pb-1'])

                @if ($pick->is_captain)
                    <i class="fas fa-copyright"></i>
                @endif

                @if ($showPrice ?? false)
                    <span class="text-muted text-xs">
                        {{ price_formatted($pick->player->price) }}
                    </span>
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

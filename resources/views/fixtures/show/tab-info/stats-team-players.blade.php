@foreach($players as $player)
    <span class="pointer" data-toggle="modal" data-target="#player-{{ $player->id }}">
        {{ $player->name }}
        @if ($player->gameweekStats->{$statsKey} > 1)
            ({{ $player->gameweekStats->{$statsKey} }})
        @endif
    </span>
    <br>
@endforeach

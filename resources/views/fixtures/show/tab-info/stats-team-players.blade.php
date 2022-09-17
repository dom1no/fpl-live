@foreach($players as $player)
    <span class="pointer" onclick='Livewire.emitTo("player-modal", "show", @json(["player" => $player->id]))'>
        {{ $player->name }}
        @if ($player->gameweekStats->{$statsKey} > 1)
            ({{ $player->gameweekStats->{$statsKey} }})
        @endif
    </span>
    <br>
@endforeach

<div class="d-flex align-items-center ml--2">
    <img src="{{ $player->getPhotoUrl() }}" class="player-photo mr-2">
    <div class="modal-title">
        <span class="display-4 lh-120">{{ $player->full_name }}</span>
        <br>
        <span class="text-muted text-sm">
            {{ $player->team->name }}
        </span>
        <br>
        <span class="text-muted text-xs">
            {{ $player->position->title() }}
        </span>
        <br>
        <span class="text-muted text-xs">
            {{ price_formatted($player->price) }}
        </span>
    </div>
</div>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>

<div class="modal fade player-modal" id="player-modal" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @isset($player)
                <div class="modal-header px-3 pt-3 pb-0">
                    @include('components.player-modal.head')
                </div>
                <div class="modal-body px-0 pb-2 pt-0">
                    @include('components.player-modal.body')
                </div>
            @else
                Loading...
            @endisset
        </div>
    </div>
</div>

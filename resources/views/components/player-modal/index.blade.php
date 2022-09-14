@once('modal-player-' . $player->id)
    @push('modals')
        <div class="modal fade" id="player-{{ $player->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header px-3 pt-3 pb-0">
                        @include('components.player-modal.head')
                    </div>
                    <div class="modal-body p-0">
                        @include('components.player-modal.body')
                    </div>
                </div>
            </div>
        </div>
    @endpush
@endonce

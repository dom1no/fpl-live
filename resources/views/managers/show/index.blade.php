<div class="display-2 text-center">{{ $manager->name }}</div>

@include('managers.show.tabs')

@each('components.player-modal.index', $manager->picks->pluck('player'), 'player')

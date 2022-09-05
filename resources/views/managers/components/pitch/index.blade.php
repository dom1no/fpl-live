<div data-testid="pitch" class="pitch">
    @foreach($mainPicks->groupBy('player.position.value') as $picks)
        <div class="pitch-row pitch-row-main">
            @foreach($picks as $pick)
                <div class="pitch-row-unit">
                    @include('managers.components.pitch.element')
                </div>
            @endforeach
        </div>
    @endforeach

    @include('managers.components.pitch.bench')
</div>

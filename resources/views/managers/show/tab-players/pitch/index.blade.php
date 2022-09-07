@push('css')
    <link type="text/css" href="{{ asset('css') }}/pitch.css?v=1.0.2" rel="stylesheet">
@endpush

<div data-testid="pitch" class="pitch">
    @foreach($mainPicks->groupBy('player.position.value') as $picks)
        <div class="pitch-row pitch-row-main">
            @if ($picks->count() < 4)
                <div class="pitch-row-unit"></div>
            @endif
            @foreach($picks as $pick)
                <div class="pitch-row-unit">
                    @include('managers.show.tab-players.pitch.element')
                </div>
            @endforeach
            @if ($picks->count() < 4)
                <div class="pitch-row-unit"></div>
            @endif
        </div>
    @endforeach

    @include('managers.show.tab-players.pitch.bench')
</div>

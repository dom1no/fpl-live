<div class="col-sm text-center">
    <span class="size">{{ $fixture->kickoff_time->format('d.m.Y H:i') }}</span>

    <br>
    <div class="display-3 d-flex justify-content-center text-autosize-container">
        @php($maxTeamNameLength = max(Str::length($homeTeam->name), Str::length($awayTeam->name)))

        <div class="text-right mr-2 text-autosize-element">
            {!! Str::replace('&', '&nbsp', Str::padLeft($homeTeam->name, $maxTeamNameLength, "&")) !!}
        </div>

        <div class="text-center text-autosize-element">
            @if ($fixture->isFeature())
                -
            @else
                {{ $fixture->score_formatted }}
            @endif
        </div>
        <div class="text-left ml-2 text-autosize-element">
            {!! Str::replace('&', '&nbsp', Str::padRight($awayTeam->name, $maxTeamNameLength, "&")) !!}
        </div>
    </div>

    @if ($fixture->isInProgress())
        <span class="size">
            {{ $fixture->minutes }}'
        </span>
    @elseif ($fixture->isFinished())
        <span class="size">
            Завершен
        </span>
    @endif
</div>

@include('components.text-autosize-script')

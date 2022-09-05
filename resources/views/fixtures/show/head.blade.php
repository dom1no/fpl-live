<div class="col-sm text-center">
    <span class="size">{{ $fixture->kickoff_time->format('d.m.Y H:i') }}</span>

    <br>
    <span class="display-3">
        {{ $homeTeam->name }}
        @if ($fixture->isFeature())
            -
        @else
            {{ $fixture->score_formatted }}
        @endif
        {{ $awayTeam->name }}
    </span>

    <br>
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

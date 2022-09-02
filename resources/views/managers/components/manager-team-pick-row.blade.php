@php($player = $pick->player)
@php($fixture = $player->team->fixtures->first())

<tr class="@if($fixture->isFinished())font-weight-bold @endif">
    <td>
        {{ $player->name }}
        @if ($pick->is_captain)
            <i class="fas fa-copyright"></i>
        @endif
        <br>
        <span class="text-muted">
            {{ $player->team->short_name }}
            @if ($showPosition ?? false)
                {{ $player->position->title() }}
            @endif
        </span>
    </td>
    <td>
        @if ($pick->multiplier > 0 && ($pick->points > 0 || !$fixture->isFeature()))
            {{ $pick->points }}
            @if ($pick->clean_points >= 10)
                <i class="fas fa-angle-double-up text-success"></i>
            @elseif ($pick->clean_points >= 7)
                <i class="fas fa-angle-up text-success"></i>
            @elseif ($pick->clean_points >= 3)
                <i class="fas fa-angle-up text-primary"></i>
            @elseif ($pick->clean_points >= 0)
                <i class="fas fa-minus text-warning"></i>
            @else
                <i class="fas fa-angle-double-down text-danger"></i>
            @endif
        @else
            -
        @endif
    </td>
    <td>
        <a href="{{ route('fixtures.show', $fixture) }}">
            <span class="@if ($fixture->homeTeam->id == $player->team_id) text-underline @endif">{{ $fixture->homeTeam->name }}</span>
            @if ($fixture->isFeature())
                -
            @else
                {{ $fixture->score_formatted }}
            @endif
            <span class="@if ($fixture->awayTeam->id == $player->team_id) text-underline @endif">{{ $fixture->awayTeam->name }}</span>
        </a>
    </td>
    <td>
        {{ price_formatted($player->price) }}
    </td>
    <td>
        {{ round($pick->points / $player->price, 1) }}
    </td>
</tr>

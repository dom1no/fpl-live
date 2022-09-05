@php($player = $pick->player)
@php($fixture = $player->team->fixtures->first())

<tr class="@if($fixture->isFinished())font-weight-bold @endif">
    <td>
        {{ $player->name }}
        @if ($pick->is_captain)
            <i class="fas fa-copyright"></i>
        @endif
        @if ($manager->autoSubs->contains('player_out_id', $pick->player_id))
            <i class="fas fa-exchange-alt text-danger"></i>
        @endif
        @if ($manager->autoSubs->contains('player_in_id', $pick->player_id))
            <i class="fas fa-exchange-alt text-success"></i>
        @endif
        <br>
        <span class="text-muted">
            {{ $player->team->name }}
        </span>
        @if ($showPosition ?? false)
            <br>
            <span class="text-muted font-weight-normal">
                {{ $player->position->title() }}
            </span>
        @endif
    </td>
    <td>
        @include('components.pick-points')
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

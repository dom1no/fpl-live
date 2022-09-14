@php
    $gameweek ??= request()->gameweek();
    $player = $pick->player;
    $fixture = $player->team->fixtures->firstWhere('gameweek_id', $gameweek->id) ?: optional();
@endphp

<tr @class(['font-weight-bold' => $fixture->isFinished()])>
    <td>
        <span data-toggle="modal" data-target="#player-{{ $player->id }}" class="pointer">
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
        </span>
        <span class="d-block d-md-none text-truncate">
            @include('fixtures.components.fixture-link', ['showShortNames' => true])
        </span>
    </td>
    <td>
        @include('managers.components.pick-points')
    </td>
    <td class="d-none d-md-table-cell">
        @include('fixtures.components.fixture-link')
    </td>
    <td>
        {{ price_formatted($player->price) }}
    </td>
    {{--    <td>--}}
    {{--        {{ round($pick->points / $player->price, 1) }}--}}
    {{--    </td>--}}
</tr>

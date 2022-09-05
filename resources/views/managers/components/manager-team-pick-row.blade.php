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
        <span class="d-block d-md-none text-truncate">
            @include('components.fixture-link', ['showShortNames' => true])
        </span>
    </td>
    <td>
        @include('components.pick-points')
    </td>
    <td class="d-none d-md-table-cell">
        @include('components.fixture-link')
    </td>
    <td>
        {{ price_formatted($player->price) }}
    </td>
    {{--    <td>--}}
    {{--        {{ round($pick->points / $player->price, 1) }}--}}
    {{--    </td>--}}
</tr>

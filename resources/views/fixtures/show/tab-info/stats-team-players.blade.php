@php($statsPlayers = $players->where("gameweekStats.{$statsKey}", '>', 0))
@if ($statsPlayers->isNotEmpty())
    <tr>
        <td colspan="100%" class="text-center bg-secondary py-2 font-weight-bold">
            {{ $statsName }}
        </td>
    </tr>
    <tr>
        <td class="text-right border-right" style="width: 50%;">
            @foreach($statsPlayers->where('team_id', $homeTeam->id) as $player)
                {{ $player->name }}
                @if ($player->gameweekStats->{$statsKey} > 1)
                    ({{ $player->gameweekStats->{$statsKey} }})
                @endif
                <br>
            @endforeach
        </td>
        <td class="text-left" style="width: 50%;">
            @foreach($statsPlayers->where('team_id', $awayTeam->id) as $player)
                {{ $player->name }}
                @if ($player->gameweekStats->{$statsKey} > 1)
                    ({{ $player->gameweekStats->{$statsKey} }})
                @endif
            @endforeach
        </td>
    </tr>
@endif

@php($statsPlayers = $players->where("gameweekStats.{$statsKey}", '>', 0)->sortByDesc("gameweekStats.{$statsKey}"))

@if ($statsPlayers->isNotEmpty())
    <tr>
        <td colspan="100%" class="text-center bg-secondary py-2 font-weight-bold">
            {{ $statsName }}
        </td>
    </tr>
    <tr>
        <td class="text-right border-right" style="width: 50%;">
            @include('fixtures.show.tab-info.stats-team-players', [
                'players' => $statsPlayers->where('team_id', $homeTeam->id)
            ])
        </td>
        <td class="text-left" style="width: 50%;">
            @include('fixtures.show.tab-info.stats-team-players', [
                'players' => $statsPlayers->where('team_id', $awayTeam->id)
            ])
        </td>
    </tr>
@endif

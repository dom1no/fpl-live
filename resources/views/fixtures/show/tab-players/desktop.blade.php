<div class="col-sm-6">
    @include('fixtures.show.tab-players.team-players', [
        'team' => $homeTeam,
        'players' => $players->where('team_id', $homeTeam->id)
    ])
</div>

<div class="col-sm-6">
    @include('fixtures.show.tab-players.team-players', [
        'team' => $awayTeam,
        'players' => $players->where('team_id', $awayTeam->id)
    ])
</div>

<div class="col-sm-6">
    @include('fixtures.show.tab-players.team-players', [
        'team' => $fixture->homeTeam,
        'players' => $players->where('team_id', $fixture->homeTeam->id)
    ])
</div>

<div class="col-sm-6">
    @include('fixtures.show.tab-players.team-players', [
        'team' => $fixture->awayTeam,
        'players' => $players->where('team_id', $fixture->awayTeam->id)
    ])
</div>

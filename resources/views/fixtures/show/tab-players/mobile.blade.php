<div class="nav-wrapper">
    <ul class="nav nav-pills nav-fill text-center" id="tabs-fixture-teams"
        role="tablist">
        <li class="nav-item col-6">
            <a class="nav-link active" id="tabs-fixture-home-team-tab"
               data-toggle="tab" href="#tabs-fixture-home-team" role="tab"
               aria-controls="tabs-fixture-home-team" aria-selected="true">
                {{ $homeTeam->name }}
            </a>
        </li>
        <li class="nav-item col-6">
            <a class="nav-link" id="tabs-fixture-away-team-tab" data-toggle="tab"
               href="#tabs-fixture-away-team" role="tab" aria-controls="tabs-fixture-away-team"
               aria-selected="false">
                {{ $awayTeam->name }}
            </a>
        </li>
    </ul>
</div>
<div class="tab-content">
    <div class="tab-pane fade show active" id="tabs-fixture-home-team" role="tabpanel"
         aria-labelledby="tabs-fixture-home-team-tab">
        @include('fixtures.show.tab-players.team-players', [
            'team' => $homeTeam,
            'players' => $players->where('team_id', $homeTeam->id)
        ])
    </div>
    <div class="tab-pane fade" id="tabs-fixture-away-team" role="tabpanel"
         aria-labelledby="tabs-fixture-away-team-tab">
        @include('fixtures.show.tab-players.team-players', [
            'team' => $awayTeam,
            'players' => $players->where('team_id', $awayTeam->id)
        ])
    </div>
</div>

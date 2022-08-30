@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm text-center">
            <span class="size">{{ $fixture->kickoff_time->format('d.m.Y H:i') }}</span>
            <p class="display-3">
                {{ $fixture->homeTeam->name }}
                @if ($fixture->isFeature())
                    -
                @else
                    {{ $fixture->home_team_score }}:{{ $fixture->away_team_score }}
                @endif
                {{ $fixture->awayTeam->name }}
            </p>
        </div>
    </div>

    <div class="nav-wrapper">
        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
            <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                   href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i
                        class="ni ni-cloud-upload-96 mr-2"></i>Match</a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                   href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i
                        class="ni ni-bell-55 mr-2"></i>Mangers Profit</a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
             aria-labelledby="tabs-icons-text-1-tab">
            <div class="row">
                @include('fixtures.components.team-card', [
                    'team' => $fixture->homeTeam,
                    'players' => $players->where('team_id', $fixture->home_team_id)
                ])
                @include('fixtures.components.team-card', [
                    'team' => $fixture->awayTeam,
                    'players' => $players->where('team_id', $fixture->away_team_id)
                ])
            </div>
        </div>
        <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
            <div class="row">
                @include('fixtures.components.managers-profit')
            </div>
        </div>
    </div>
@endsection

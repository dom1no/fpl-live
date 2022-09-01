@extends('layouts.app', ['fluid' => true])

@section('content')
    <div class="row">
        <div class="col-sm text-center">
            <span class="size">{{ $fixture->kickoff_time->format('d.m.Y H:i') }}</span>
            <br>
            <span class="display-3">
                {{ $fixture->homeTeam->name }}
                @if ($fixture->isFeature())
                    -
                @else
                    {{ $fixture->score_formatted }}
                @endif
                {{ $fixture->awayTeam->name }}
            </span>
            <br>
            @if ($fixture->isInProgress())
                <span class="size">
                    {{ $fixture->minutes }}'
                </span>
            @elseif ($fixture->isFinished())
                <span class="size">
                    Завершен
                </span>
            @endif
        </div>
    </div>

    <div class="nav-wrapper">
        <ul class="nav nav-pills nav-fill text-center" id="tabs-fixture" role="tablist">
            <li class="nav-item col-6">
                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-match-tab" data-toggle="tab"
                   href="#tabs-match" role="tab" aria-controls="tabs-match" aria-selected="true">
                    <i class="fas fa-futbol"></i>
                    Матч
                </a>
            </li>
            <li class="nav-item col-6">
                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-managers-points-tab" data-toggle="tab"
                   href="#tabs-managers-points" role="tab" aria-controls="tabs-managers-points" aria-selected="false">
                    <i class="fas fa-list-ol"></i>
                    Менеджеры
                </a>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tabs-match" role="tabpanel"
             aria-labelledby="tabs-match-tab">
            <div class="d-block d-md-none">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills row text-center" id="tabs-fixture-teams"
                            role="tablist">
                            <li class="nav-item col-6">
                                <a class="nav-link active" id="tabs-fixture-home-team-tab"
                                   data-toggle="tab" href="#tabs-fixture-home-team" role="tab"
                                   aria-controls="tabs-fixture-home-team" aria-selected="true">
                                    {{ $fixture->homeTeam->name }}
                                </a>
                            </li>
                            <li class="nav-item col-6">
                                <a class="nav-link" id="tabs-fixture-away-team-tab" data-toggle="tab"
                                   href="#tabs-fixture-away-team" role="tab" aria-controls="tabs-fixture-away-team"
                                   aria-selected="false">
                                    {{ $fixture->awayTeam->name }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-0 card-">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tabs-fixture-home-team" role="tabpanel" aria-labelledby="tabs-fixture-home-team-tab">
                                @include('fixtures.components.team-card', [
                                    'team' => $fixture->homeTeam,
                                    'players' => $players->where('team_id', $fixture->homeTeam->id)
                                ])
                            </div>
                            <div class="tab-pane fade" id="tabs-fixture-away-team" role="tabpanel" aria-labelledby="tabs-fixture-away-team-tab">
                                @include('fixtures.components.team-card', [
                                    'team' => $fixture->awayTeam,
                                    'players' => $players->where('team_id', $fixture->awayTeam->id)
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-none d-md-flex">
                <div class="col-sm-6">
                    @include('fixtures.components.team-card', [
                        'team' => $fixture->homeTeam,
                        'players' => $players->where('team_id', $fixture->homeTeam->id)
                    ])
                </div>
                <div class="col-md-6">
                    @include('fixtures.components.team-card', [
                        'team' => $fixture->awayTeam,
                        'players' => $players->where('team_id', $fixture->awayTeam->id)
                    ])
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabs-managers-points" role="tabpanel" aria-labelledby="tabs-managers-points-tab">
            <div class="row">
                @include('fixtures.components.managers-profit')
            </div>
        </div>
    </div>
@endsection

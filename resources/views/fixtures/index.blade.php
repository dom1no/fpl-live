@extends('layouts.app')

@section('content')
    @php
        [$currentGameweeks, $gameweeks] = $gameweeks->partition('is_current', true);
        $currentGameweek = $currentGameweeks->first();
        [$previousGameweeks, $featureGameweeks] = $gameweeks->partition('is_finished', true);
    @endphp

    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <h2>
                        {{ $currentGameweek->name }}
                    </h2>
                </div>
                <div class="card-body">
                    @include('fixtures.components.fixtures-list', ['gameweek' => $currentGameweek])
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm">
            <h3>Прошедшие</h3>
            <div class="accordion" id="gameweeks-accordion-previous">
                @foreach($previousGameweeks as $gameweek)
                    <div class="card">
                        <div class="card-header" id="heading-gameweek-{{ $gameweek->id }}">
                            <h5 class="mb-0">
                                <button class="btn btn-link w-100 text-primary text-left" type="button"
                                        data-toggle="collapse" data-target="#collapse-gameweek-{{ $gameweek->id }}"
                                        aria-expanded="true" aria-controls="collapse-gameweek-{{ $gameweek->id }}">
                                    {{ $gameweek->name }}
                                    <i class="ni ni-bold-down float-right"></i>
                                </button>
                            </h5>
                        </div>
                        <div id="collapse-gameweek-{{ $gameweek->id }}"
                             class="collapse @if($gameweek->is_current)show @endif"
                             aria-labelledby="heading-gameweek-{{ $gameweek->id }}">
                            @include('fixtures.components.fixtures-list', ['gameweek' => $gameweek])
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-sm">
            <h3>Будущие</h3>
            <div class="accordion" id="gameweeks-accordion-feature">
                @foreach($featureGameweeks as $gameweek)
                    <div class="card">
                        <div class="card-header" id="heading-gameweek-{{ $gameweek->id }}">
                            <h5 class="mb-0">
                                <button class="btn btn-link w-100 text-primary text-left" type="button"
                                        data-toggle="collapse" data-target="#collapse-gameweek-{{ $gameweek->id }}"
                                        aria-expanded="true" aria-controls="collapse-gameweek-{{ $gameweek->id }}">
                                    {{ $gameweek->name }}
                                    (Deadline: {{ $gameweek->deadline_at->format('d.m.Y H:i') }})
                                    <i class="ni ni-bold-down float-right"></i>
                                </button>
                            </h5>
                        </div>
                        <div id="collapse-gameweek-{{ $gameweek->id }}"
                             class="collapse @if($gameweek->is_current)show @endif"
                             aria-labelledby="heading-gameweek-{{ $gameweek->id }}">
                            @include('fixtures.components.fixtures-list', ['gameweek' => $gameweek])
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

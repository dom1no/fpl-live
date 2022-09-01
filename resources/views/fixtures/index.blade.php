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
                    <p class="display-3">
                        {{ $currentGameweek->name }}
                        <a href="{{ route('fixtures.sync') }}" class="btn btn-primary btn-sm float-right">
                            Обновить данные
                        </a>
                    </p>
                </div>
                <div class="card-body p-0">
                    @include('fixtures.components.fixtures-list', ['gameweek' => $currentGameweek])
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-6">
            <h2 class="mt-3 mt-sm-0">Прошедшие</h2>
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
        <div class="col-sm-6">
            <h2 class="mt-3 mt-sm-0">Будущие</h2>
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

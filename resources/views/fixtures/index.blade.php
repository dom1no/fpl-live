@extends('layouts.app')

@section('content')
    @php
        [$currentGameweeks, $gameweeks] = $gameweeks->partition('is_current', true);
        $currentGameweek = $currentGameweeks->first();
        [$previousGameweeks, $featureGameweeks] = $gameweeks->partition('is_finished', true);
    @endphp

    <p class="display-3 text-center">
        {{ $currentGameweek->name }}
    </p>

    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-body p-0">
                    @include('fixtures.index.table', ['gameweek' => $currentGameweek])
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-6">
            <h2 class="mt-3 mt-sm-0">Прошедшие</h2>
            @include('fixtures.index.gameweeks-accordion', ['gameweeks' => $previousGameweeks])
        </div>
        <div class="col-sm-6">
            <h2 class="mt-3 mt-sm-0">Будущие</h2>
            @include('fixtures.index.gameweeks-accordion', ['gameweeks' => $featureGameweeks])
        </div>
    </div>
@endsection

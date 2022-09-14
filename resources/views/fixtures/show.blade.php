@extends('layouts.app')

@section('content')
    @php
        $homeTeam = $fixture->homeTeam;
        $awayTeam = $fixture->awayTeam;
    @endphp

    <div class="row">
        @include('fixtures.show.head')
    </div>

    @include('fixtures.show.tabs')

    @foreach($players as $player)
        @include('components.player-modal.index', ['currentFixture' => $fixture])
    @endforeach
@endsection

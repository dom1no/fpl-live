@extends('layouts.app')

@section('content')
    @php($homeTeam = $fixture->homeTeam)
    @php($awayTeam = $fixture->awayTeam)

    <div class="row">
        @include('fixtures.show.head')
    </div>

    @include('fixtures.show.tabs')
@endsection

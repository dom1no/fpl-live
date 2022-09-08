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
@endsection

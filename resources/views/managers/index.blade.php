@extends('layouts.app')

@section('content')
    <p class="display-3">{{ $gameweek->name }}</p>
    <div class="row">
        @foreach($managers as $manager)
            <div class="col-sm-4">
                @include('managers.components.manager-team-card')
            </div>
        @endforeach
    </div>
@endsection

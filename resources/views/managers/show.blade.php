@extends('layouts.app')

@section('content')
    <p class="display-3 text-center">{{ $gameweek->name }}</p>
    <div class="row">
        <div class="col-sm-12">
            @include('managers.show.card')
        </div>
    </div>
@endsection

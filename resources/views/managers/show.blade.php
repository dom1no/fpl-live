@extends('layouts.app')

@section('content')
    <p class="display-3">{{ $gameweek->name }}</p>
    <div class="row">
        <div class="col-sm-12">
            @include('managers.components.manager-card')
        </div>
    </div>
@endsection

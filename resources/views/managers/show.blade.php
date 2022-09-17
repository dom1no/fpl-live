@extends('layouts.app')

@section('content')
    @include('components.gameweek.header')

    <div class="row">
        <div class="col-sm-12">
            @include('managers.show.index')
        </div>
    </div>
@endsection

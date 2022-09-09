@extends('layouts.app')

@section('content')
    @include('components.gameweek-title')

    <div class="row">
        <div class="col-sm-12">
            @include('managers.show.index')
        </div>
    </div>
@endsection

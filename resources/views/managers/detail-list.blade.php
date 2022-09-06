@extends('layouts.app', ['fluid' => true])

@section('content')
    <p class="display-3 text-center">{{ $gameweek->name }}</p>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                @include('managers.detail-list.table')
            </div>
        </div>
    </div>
@endsection

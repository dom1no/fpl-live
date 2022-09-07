@extends('layouts.app', ['fluid' => true])

@section('content')
    @include('components.gameweek-title')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                @include('managers.detail-list.table')
            </div>
        </div>
    </div>
@endsection

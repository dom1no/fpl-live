@extends('layouts.app', ['fluid' => true])

@section('content')
    @include('components.gameweek.header')

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow">
                @include('managers.detail-list.table')
            </div>
        </div>
    </div>
@endsection

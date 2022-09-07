@extends('layouts.app')

@section('content')
    @include('components.gameweek-title')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                @include('managers.index.table')
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    @include('components.gameweek.header')

    <div class="row">
        <div class="col-sm">
            <div class="card shadow">
                @include('fixtures.index.table')
            </div>
        </div>
    </div>
@endsection

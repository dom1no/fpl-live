@extends('layouts.app')

@section('content')
    @include('components.gameweek.header')

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow">
                @include('managers.index.table')
            </div>
        </div>
    </div>
@endsection

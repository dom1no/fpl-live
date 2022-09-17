@extends('layouts.app')

@section('content')
    @include('components.gameweek.header')

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow">
                @include('managers.transfers.table')
            </div>
        </div>
    </div>
@endsection

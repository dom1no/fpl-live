@extends('layouts.app')

@section('content')
    @include('components.gameweek-title', [
        'canViewFeature' => true,
    ])

    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-body p-0">
                    @include('fixtures.index.table')
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    @php
        $homeTeam = $fixture->homeTeam;
        $awayTeam = $fixture->awayTeam;
    @endphp

    <div class="row">
        @include('fixtures.show.head')
    </div>

    @include('fixtures.show.tabs')
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(() => {
            Livewire.emitTo('player-modal', 'setCurrentFixture', @json(['fixture' => $fixture->id]))
        })
    </script>
@endpush

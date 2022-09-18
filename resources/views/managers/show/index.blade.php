<div class="display-2 text-center">{{ $manager->name }}</div>

@if (!$gameweek->isFeature())
    @include('managers.show.head')
@endif

@include('managers.show.tabs')

@php
    $countTabs = 4;
    if (auth()->guest()) {
        $countTabs--;
    }
    if (! $fixture->fot_mob_link) {
        $countTabs--;
    }
@endphp
<div class="nav-wrapper @if($countTabs === 4) offset-md-1 col-md-10 @endif">
    <ul class="nav nav-pills nav-fill text-center nav-persistent" id="tabs-fixture" role="tablist">
        <li class="nav-item col-12 col-md-3 offset-md-{{ $countTabs === 4 ? 0 : ($countTabs === 3 ? 2 : 3) }}">
            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-players-tab" data-toggle="tab"
               href="#tabs-players" role="tab" aria-controls="tabs-players" aria-selected="true">
                <i class="fas fa-users"></i>
                Игроки
            </a>
        </li>
        @auth
            <li class="nav-item col-12 col-md-3">
                <a class="nav-link mb-sm-3 mb-md-0" id="tabs-managers-tab" data-toggle="tab"
                   href="#tabs-managers" role="tab" aria-controls="tabs-managers" aria-selected="false">
                    <i class="fas fa-list-ol"></i>
                    Менеджеры
                </a>
            </li>
        @endauth
        <li class="nav-item col-12 col-md-3">
            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-info-tab" data-toggle="tab"
               href="#tabs-info" role="tab" aria-controls="tabs-info" aria-selected="false">
                <i class="fas fa-futbol"></i>
                Матч
            </a>
        </li>
        @if ($fixture->fot_mob_link)
            <li class="nav-item col-12 col-md-3">
                <a class="nav-link mb-sm-3 mb-md-0" href="{{ $fixture->fot_mob_link }}" target="_blank">
                    <i class="fas fa-chart-bar"></i>
                    FotMob.com
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </li>
        @endif
    </ul>
</div>

<div class="tab-content">
    <div class="tab-pane fade show active" id="tabs-players" role="tabpanel" aria-labelledby="tabs-players-tab">
        @include('fixtures.show.tab-players.index')
    </div>
    @auth
        <div class="tab-pane fade" id="tabs-managers" role="tabpanel" aria-labelledby="tabs-managers-tab">
            @include('fixtures.show.tab-managers.index')
        </div>
    @endauth
    <div class="tab-pane fade" id="tabs-info" role="tabpanel" aria-labelledby="tabs-info-tab">
        @include('fixtures.show.tab-info.index')
    </div>
</div>

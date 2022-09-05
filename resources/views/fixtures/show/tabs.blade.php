<div class="nav-wrapper">
    <ul class="nav nav-pills nav-fill text-center" id="tabs-fixture" role="tablist">
        <li class="nav-item col-6 col-md-3 offset-md-3">
            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-players-tab" data-toggle="tab"
               href="#tabs-players" role="tab" aria-controls="tabs-players" aria-selected="true">
                <i class="fas fa-futbol"></i>
                Матч
            </a>
        </li>
        <li class="nav-item col-6 col-md-3">
            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-managers-tab" data-toggle="tab"
               href="#tabs-managers" role="tab" aria-controls="tabs-managers" aria-selected="false">
                <i class="fas fa-list-ol"></i>
                Менеджеры
            </a>
        </li>
    </ul>
</div>

<div class="tab-content">
    <div class="tab-pane fade show active" id="tabs-players" role="tabpanel" aria-labelledby="tabs-players-tab">
        @include('fixtures.show.tab-players.index')
    </div>
    <div class="tab-pane fade" id="tabs-managers" role="tabpanel" aria-labelledby="tabs-managers-tab">
        @include('fixtures.show.tab-managers')
    </div>
</div>

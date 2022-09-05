<div class="nav-wrapper">
    <ul class="nav nav-pills nav-fill text-center" id="tabs-fixture" role="tablist">
        <li class="nav-item col-12 col-md-3">
            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-players-tab" data-toggle="tab"
               href="#tabs-players" role="tab" aria-controls="tabs-players" aria-selected="true">
                <i class="fas fa-users"></i>
                Состав
            </a>
        </li>
        <li class="nav-item col-12 col-md-3">
            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-transfers-tab" data-toggle="tab"
               href="#tabs-transfers" role="tab" aria-controls="tabs-transfers" aria-selected="false">
                <i class="fas fa-list-ol"></i>
                Трансферы
            </a>
        </li>
    </ul>
</div>

<div class="tab-content">
    <div class="tab-pane fade show active" id="tabs-players" role="tabpanel" aria-labelledby="tabs-players-tab">
        @include('managers.show.tab-players.index')
    </div>
    <div class="tab-pane fade" id="tabs-transfers" role="tabpanel" aria-labelledby="tabs-transfers-tab">
        @include('managers.show.tab-transfers.index')
    </div>
</div>

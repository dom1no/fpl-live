<div class="nav-wrapper">
    <ul class="nav nav-pills nav-fill text-center" id="tabs-squad-view" role="tablist">
        <li class="nav-item col-6 col-md-3 offset-md-3">
            <a class="nav-link py-2 active" id="tabs-squad-pitch-view-tab"
               data-toggle="tab" href="#tabs-squad-pitch-view" role="tab"
               aria-controls="tabs-squad-pitch-view" aria-selected="true">
                Расстановка
            </a>
        </li>
        <li class="nav-item col-6 col-md-3">
            <a class="nav-link py-2" id="tabs-squad-table-view-tab" data-toggle="tab"
               href="#tabs-squad-table-view" role="tab"
               aria-controls="tabs-squad-table-view"
               aria-selected="false">
                Список
            </a>
        </li>
    </ul>
</div>

@php([$mainPicks, $benchPicks] = $manager->picks->partition(fn ($pick) => $pick->position <= 11))

<div class="tab-content">
    <div class="tab-pane fade show active" id="tabs-squad-pitch-view" role="tabpanel"
         aria-labelledby="tabs-squad-pitch-view-tab">
        <div class="col-12 col-md-10 offset-md-1 p-0">
            @include('managers.show.tab-players.pitch.index')
        </div>
    </div>
    <div class="tab-pane fade" id="tabs-squad-table-view" role="tabpanel"
         aria-labelledby="tabs-squad-table-view-tab">
        @include('managers.show.tab-players.players-table')
    </div>
</div>

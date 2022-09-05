<div class="nav-wrapper pr-3">
    <ul class="nav nav-pills nav-fill text-center" role="tablist">
        <li class="nav-item col-6 col-sm-3">
            <a class="nav-link p-2 active" id="tabs-manager-table-team-tab"
               data-toggle="tab" href="#tabs-manager-table-team" role="tab"
               aria-controls="tabs-manager-table-team" aria-selected="true">
                Table view
            </a>
        </li>
        <li class="nav-item col-6 col-sm-3">
            <a class="nav-link p-2" id="tabs-manager-pitch-tab" data-toggle="tab"
               href="#tabs-manager-pitch" role="tab"
               aria-controls="tabs-manager-pitch"
               aria-selected="false">
                Pitch view
            </a>
        </li>
    </ul>
</div>

@php([$mainPicks, $benchPicks] = $manager->picks->partition(fn ($pick) => $pick->position <= 11))

<div class="tab-content">
    <div class="tab-pane fade show active" id="tabs-manager-table-team" role="tabpanel"
         aria-labelledby="tabs-manager-table-team-tab">
        @include('managers.show.tab-players.players-table')
    </div>
    <div class="tab-pane fade" id="tabs-manager-pitch" role="tabpanel"
         aria-labelledby="tabs-manager-pitch-tab">
        @include('managers.show.tab-players.pitch.index')
    </div>
</div>

<div class="nav-wrapper pr-3">
    <ul class="nav nav-pills nav-fill text-center" role="tablist">
        <li class="nav-item col-6 col-sm-3">
            <a class="nav-link p-2 active" id="tabs-manager-{{ $manager->id }}-table-team-tab"
               data-toggle="tab" href="#tabs-manager-{{ $manager->id }}-table-team" role="tab"
               aria-controls="tabs-manager-{{ $manager->id }}-table-team" aria-selected="true">
                Table view
            </a>
        </li>
        <li class="nav-item col-6 col-sm-3">
            <a class="nav-link p-2" id="tabs-manager-{{ $manager->id }}-pitch-tab" data-toggle="tab"
               href="#tabs-manager-{{ $manager->id }}-pitch" role="tab"
               aria-controls="tabs-manager-{{ $manager->id }}-pitch"
               aria-selected="false">
                Pitch view
            </a>
        </li>
    </ul>
</div>

@php([$mainPicks, $benchPicks] = $manager->picks->partition(fn ($pick) => $pick->position <= 11))

<div class="tab-content">
    <div class="tab-pane fade show active" id="tabs-manager-{{ $manager->id }}-table-team" role="tabpanel"
         aria-labelledby="tabs-manager-{{ $manager->id }}-table-team-tab">
        @include('managers.components.team-players-table')
    </div>
    <div class="tab-pane fade" id="tabs-manager-{{ $manager->id }}-pitch" role="tabpanel"
         aria-labelledby="tabs-manager-{{ $manager->id }}-pitch-tab">
        @include('managers.components.pitch.index')
    </div>
</div>

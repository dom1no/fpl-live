<div class="card">
    <div class="card-body py-2 row text-center">
        <div class="col-6 h5 pb-2 border-bottom">Тур</div>
        <div class="col-6 h5 pb-2 border-left border-bottom">Всего</div>
        <div class="clearfix"></div>

        <div class="col-3 col-sm-4">
            <div class="h5 mb-0">Очки</div>
            <div class="display-3">
                {{ $manager->gameweekPointsHistory->points }}
                @if ($transfersCost = $manager->gameweekPointsHistory->transfers_cost)
                    <span class="d-inline-block text-sm opacity-7">
                        (-{{ $transfersCost }})
                    </span>
                @endif
            </div>
        </div>
        <div class="col-3 col-sm-2">
            <div class="h5 mb-0">Место</div>
            <div class="display-3">
                {{ $manager->gameweekPointsHistory->position }}
            </div>
        </div>
        <div class="col-3 col-sm-4 border-left">
            <div class="h5 mb-0">Всего</div>
            <div class="display-4">
                {{ $manager->gameweekPointsHistory->total_points }}
            </div>
        </div>
        <div class="col-3 col-sm-2">
            <div class="h5 mb-0">Место</div>
            <div class="display-4">
                {{ $manager->gameweekPointsHistory->total_position }}
            </div>
        </div>
    </div>
</div>

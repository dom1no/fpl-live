@php
    use App\Models\Fixture;
    $gameweek ??= request()->gameweek();

    $currentFixture ??= $player->team->fixtures->firstWhere('gameweek_id', $gameweek->id) ?: optional();
    [$futureFixture, $pastFixtures] = $player->team->fixtures->partition(fn(Fixture $fixture) => $fixture->isFeature());
@endphp


<div class="nav-wrapper">
    <ul class="nav nav-pills nav-fill text-center nav-persistent" role="tablist">
        <li class="nav-item col-12 col-md-6">
            <a class="nav-link mb-sm-3 mb-md-0 @if (!$currentFixture->isFeature()) active @endif" id="player-{{ $player->id }}-modal-tabs-past-fixtures-tab" data-toggle="tab"
               href="#player-{{ $player->id }}-modal-tabs-past-fixtures" role="tab">
                <i class="fas fa-users"></i>
                Прошедшие матчи
            </a>
        </li>
        <li class="nav-item col-12 col-md-6">
            <a class="nav-link mb-sm-3 mb-md-0 @if ($currentFixture->isFeature()) active @endif" id="player-{{ $player->id }}-modal-tabs-future-fixtures-tab" data-toggle="tab"
               href="#player-{{ $player->id }}-modal-tabs-future-fixtures" role="tab">
                <i class="fas fa-list-ol"></i>
                Будущие матчи
            </a>
        </li>
    </ul>
</div>

<div class="tab-content">
    <div class="tab-pane fade @if (!$currentFixture->isFeature()) show active @endif" id="player-{{ $player->id }}-modal-tabs-past-fixtures" role="tabpanel"
         aria-labelledby="player-{{ $player->id }}-modal-tabs-past-fixtures-tab">
        @include('components.player-modal.past-fixtures', ['fixtures' => $pastFixtures])
    </div>
    <div class="tab-pane fade @if ($currentFixture->isFeature()) show active @endif" id="player-{{ $player->id }}-modal-tabs-future-fixtures" role="tabpanel"
         aria-labelledby="player-{{ $player->id }}-modal-tabs-future-fixtures-tab">
        @include('components.player-modal.future-fixtures', ['fixtures' => $futureFixture])
    </div>
</div>

@once
    @push('js')
        <script type="text/javascript">
            $(document).ready(function () {
                $('.player-modal').on('shown.bs.modal', function () {
                    let activeFixture = $(this).find('.focused');
                    if (activeFixture.length > 0) {
                        activeFixture.get(0).scrollIntoView();
                    }
                });
            });
        </script>
    @endpush
@endonce

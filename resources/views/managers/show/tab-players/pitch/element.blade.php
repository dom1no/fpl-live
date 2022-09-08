@php use App\Models\Enums\PlayerPosition; @endphp

@php
    $team = $pick->player->team;
    $fixture = $team->fixtures->first();
    $isGKP = $pick->player->position === PlayerPosition::GOALKEEPER;
@endphp

<div class="pitch-row-unit-element-wrapper">
    <div class="pitch-row-unit-element">
        <button type="button" class="pitch-row-unit-element-shirt">
            @include('managers.show.tab-players.pitch.element.shirt')

            <div @class(['pitch-row-unit-element-data', 'font-weight-bold' => $fixture->isFinished()])>
                <div class="pitch-row-unit-element-name text-autosize-container">
                    <span class="text-autosize-element">{{ $pick->player->name }}</span>
                </div>

                <div class="pitch-row-unit-element-value text-dark">
                    @include('managers.components.pick-points', [
                        'showIcon' => false,
                    ])
                </div>

                <div class="pitch-row-unit-element-fixture text-dark">
                    @include('fixtures.components.fixture-link', [
                        'showShortNames' => true,
                        'linkClass' => 'text-dark',
                    ])
                </div>
            </div>
        </button>

        @includeWhen($pick->is_captain, 'managers.show.tab-players.pitch.element.captain-icon')
        @includeWhen($pick->points > 0 || !$fixture->isFeature(), 'managers.show.tab-players.pitch.element.points-icon')
        @includeWhen(
            $manager->autoSubs->contains('player_out_id', $pick->player_id),
            'managers.show.tab-players.pitch.element.autosub-icon',
            ['isOut' => true]
        )
        @includeWhen(
            $manager->autoSubs->contains('player_in_id', $pick->player_id),
            'managers.show.tab-players.pitch.element.autosub-icon',
            ['isIn' => true]
        )
    </div>
</div>

@include('components.scripts.text-autosize')

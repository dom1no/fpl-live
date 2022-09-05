@php use App\Models\Enums\PlayerPosition; @endphp
@php($team = $pick->player->team)
@php($fixture = $team->fixtures->first())
@php($isGKP = $pick->player->position === PlayerPosition::GOALKEEPER)

<div class="pitch-row-unit-element-wrapper">
    <div class="pitch-row-unit-element">
        <button type="button" class="pitch-row-unit-element-shirt">
            @include('managers.show.tab-players.pitch.element-shirt')
            <div class="pitch-row-unit-element-data">
                <div class="pitch-row-unit-element-name">
                    {{ $pick->player->name }}
                </div>
                <div class="pitch-row-unit-element-value font-weight-bold">
                    @include('managers.components.pick-points')
                </div>
            </div>
        </button>

        @includeWhen($pick->is_captain, 'managers.show.tab-players.pitch.element-captain-icon')
    </div>
</div>

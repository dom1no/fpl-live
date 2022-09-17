@php use App\Models\Enums\PlayerPosition; @endphp

@php
    $gameweek ??= request()->gameweek();
    $player = $pick->player;
    $team = $player->team;
    $fixture = $player->team->fixtures->firstWhere('gameweek_id', $gameweek->id) ?: optional();
    $isGKP = $player->position === PlayerPosition::GOALKEEPER;
@endphp

<div class="pitch-row-unit-element-wrapper">
    <div @class(['pitch-row-unit-element', 'font-weight-bold' => $fixture->isFinished()])>
        <button type="button"
                @class(['pitch-row-unit-element-btn', 'font-weight-bold' => $fixture->isFinished()])
                onclick='Livewire.emitTo("player-modal", "show", @json(["player" => $player->id]))'
        >
            @include('managers.show.tab-players.pitch.element.shirt')

            <div class="pitch-row-unit-element-data">
                <div class="pitch-row-unit-element-name text-autosize-container {{ $player->isNotOk() ? "bg-{$player->status->color($player)} text-dark" : '' }}">
                    <span>{{ $player->name }}</span>
                </div>

                <div class="pitch-row-unit-element-value text-dark">
                    @include('managers.components.pick-points', [
                        'showIcon' => false,
                    ])
                </div>
            </div>
            @includeWhen($pick->is_captain, 'managers.show.tab-players.pitch.element.captain-icon')
            @includeWhen($pick->points > 0 || $fixture->isFeature() === false, 'managers.show.tab-players.pitch.element.points-icon')
            @includeWhen(
                $manager->autoSubs->contains('player_out_id', $player->id),
                'managers.show.tab-players.pitch.element.autosub-icon',
                ['isOut' => true]
            )
            @includeWhen(
                $manager->autoSubs->contains('player_in_id', $player->id),
                'managers.show.tab-players.pitch.element.autosub-icon',
                ['isIn' => true]
            )
            @includeWhen($player->isNotOk(), 'managers.show.tab-players.pitch.element.status-icon')
        </button>

        <div class="pitch-row-unit-element-fixture text-dark">
            @include('fixtures.components.fixture-link', [
                'showShortNames' => true,
                'linkClass' => 'text-dark',
            ])
        </div>
    </div>
</div>

@include('components.scripts.text-autosize')

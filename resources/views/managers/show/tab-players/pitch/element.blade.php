@php use App\Models\Enums\PlayerPosition; @endphp
@php($team = $pick->player->team)
@php($fixture = $team->fixtures->first())
@php($isGKP = $pick->player->position === PlayerPosition::GOALKEEPER)

<div class="pitch-row-unit-element-wrapper">
    <div class="pitch-row-unit-element">
        <button type="button" class="pitch-row-unit-element-shirt">
            @include('managers.show.tab-players.pitch.element-shirt')
            <div class="pitch-row-unit-element-data @if($fixture->isFinished()) font-weight-bold @endif">
                <div class="pitch-row-unit-element-name">
                    <span>{{ $pick->player->name }}</span>
                </div>
                <div class="pitch-row-unit-element-value text-dark font-weight-bold">
                    @include('managers.components.pick-points')
                </div>
                <div class="pitch-row-unit-element-fixture">
                    @include('fixtures.components.fixture-link', [
                        'showShortNames' => true,
                    ])
                </div>
            </div>
        </button>

        @includeWhen($pick->is_captain, 'managers.show.tab-players.pitch.element-captain-icon')
    </div>
</div>

@once
    @push('js')
        <script type="text/javascript">
            $(document).ready(function () {
                $('#tabs-manager-pitch-tab').on('shown.bs.tab', function () {
                    $('.pitch-row-unit-element-name span').each((i, el) => {
                        resize_to_fit($(el));
                    });
                });
            });

            function resize_to_fit(el) {
                console.log(el);

                var fontsize = el.css('font-size');

                if (el.width() > el.parent().width() + 1) {
                    el.css('fontSize', parseFloat(fontsize) - 1);
                    resize_to_fit(el);
                }
            }
        </script>
    @endpush
@endonce

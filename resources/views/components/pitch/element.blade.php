@php($fixture = $pick->player->team->fixtures->first())

<div class="pitch-row-unit-element-wrapper">
    <div class="pitch-row-unit-element">
        <button type="button" class="pitch-row-unit-element-shirt">
            <picture>
                <source type="image/webp" srcset="
        https://fantasy.premierleague.com/dist/img/shirts/standard/shirt_6_1-66.webp 66w,
        https://fantasy.premierleague.com/dist/img/shirts/standard/shirt_6_1-110.webp 110w,
        https://fantasy.premierleague.com/dist/img/shirts/standard/shirt_6_1-220.webp 220w
        " sizes="(min-width: 1024px) 55px, (min-width: 610px) 44px, 33px">
                <img src="https://fantasy.premierleague.com/dist/img/shirts/standard/shirt_6_1-66.png"
                     srcset="
        https://fantasy.premierleague.com/dist/img/shirts/standard/shirt_6_1-66.png 66w,
        https://fantasy.premierleague.com/dist/img/shirts/standard/shirt_6_1-110.png 110w,
        https://fantasy.premierleague.com/dist/img/shirts/standard/shirt_6_1-220.png 220w
        " sizes="(min-width: 1024px) 55px, (min-width: 610px) 44px, 33px" alt="Spurs"
                     class="pitch-row-unit-element-shirt-img">
            </picture>
            <div class="pitch-row-unit-element-data">
                <div class="pitch-row-unit-element-name">
                    {{ $pick->player->name }}
                </div>
                <div class="pitch-row-unit-element-value font-weight-bold">
                    @include('components.pick-points')
                </div>
            </div>
        </button>
        @includeWhen($pick->is_captain, 'components.pitch.captain-icon')
    </div>
</div>

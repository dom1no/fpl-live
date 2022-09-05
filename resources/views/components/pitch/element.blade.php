@php use App\Models\Enums\PlayerPosition; @endphp
@php($team = $pick->player->team)
@php($fixture = $team->fixtures->first())
@php($isGKP = $pick->player->position === PlayerPosition::GOALKEEPER)

<div class="pitch-row-unit-element-wrapper">
    <div class="pitch-row-unit-element">
        <button type="button" class="pitch-row-unit-element-shirt">
            <picture>
                <source type="image/webp" srcset="
                {{ Storage::disk('shirts')->url($team->getFileShirtName(66, 'webp', $isGKP)) }} 66w,
                {{ Storage::disk('shirts')->url($team->getFileShirtName(110, 'webp', $isGKP)) }} 110w,
                {{ Storage::disk('shirts')->url($team->getFileShirtName(220, 'webp', $isGKP)) }} 220w,
                " sizes="(min-width: 1024px) 55px, (min-width: 610px) 44px, 33px">
                <img src="{{ Storage::disk('shirts')->url($team->getFileShirtName(66, 'png', $isGKP)) }}"
                     srcset="
                {{ Storage::disk('shirts')->url($team->getFileShirtName(66, 'png', $isGKP)) }} 66w,
                {{ Storage::disk('shirts')->url($team->getFileShirtName(110, 'png', $isGKP)) }} 110w,
                {{ Storage::disk('shirts')->url($team->getFileShirtName(220, 'png', $isGKP)) }} 220w,
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

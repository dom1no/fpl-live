<picture>
    <source type="image/webp" srcset="
                {{ $team->getShirtUrl(66, 'webp', $isGKP) }} 66w,
                {{ $team->getShirtUrl(110, 'webp', $isGKP) }} 110w,
                {{ $team->getShirtUrl(220, 'webp', $isGKP) }} 220w,
                " sizes="(min-width: 1024px) 55px, (min-width: 610px) 44px, 33px">
    <img src="{{ $team->getShirtUrl(66, 'png', $isGKP) }}"
         srcset="
                {{ $team->getShirtUrl(66, 'png', $isGKP) }} 66w,
                {{ $team->getShirtUrl(110, 'png', $isGKP) }} 110w,
                {{ $team->getShirtUrl(220, 'png', $isGKP) }} 220w,
                " sizes="(min-width: 1024px) 55px, (min-width: 610px) 44px, 33px" alt="Spurs"
         class="pitch-row-unit-element-btn-img">
</picture>

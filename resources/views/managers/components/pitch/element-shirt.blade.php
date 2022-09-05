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

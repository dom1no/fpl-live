@forelse($chips as $chip)
    @if ($withMobileBr ?? false)
        <br class="d-block d-sm-none">
    @endif
    <span @class(['badge', 'badge-info', 'mt-1 mt-sm-0' => $withMobileBr ?? false])>
        {{ $chip->type->title() }}
    </span>
@empty
    {{ $emptyValue ?? '' }}
@endforelse

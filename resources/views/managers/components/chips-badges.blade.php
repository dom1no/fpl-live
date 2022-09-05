@forelse($chips as $chip)
    @if ($withMobileBr ?? false)
        <br class="d-block d-sm-none">
    @endif
    <span class="badge badge-{{ $badgeClass ?? 'light' }} @if($withMobileBr ?? false)mt-1 mt-sm-0 @endif">
        {{ $chip->type->title() }}
    </span>
@empty
    {{ $emptyValue ?? '' }}
@endforelse

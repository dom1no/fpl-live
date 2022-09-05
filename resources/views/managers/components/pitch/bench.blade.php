<div class="pitch-bench">
    <div class="pitch-bench-inner">
        <div class="pitch-row">
            @foreach($benchPicks as $pick)
                <div class="pitch-bench-row-unit">
                    <h3 class="pitch-bench-row-unit-heading">
                        <span class="text-underline">
                            @if ($loop->iteration > 1)
                                {{ $loop->iteration - 1 }}.
                            @endif
                            {{ $pick->player->position->value }}
                        </span>
                    </h3>
                    @include('managers.components.pitch.element', ['showCleanPoints' => true])
                </div>
            @endforeach
        </div>
    </div>
</div>

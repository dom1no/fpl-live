<div class="accordion">
    @foreach($gameweeks as $gameweek)
        <div class="card">
            <div class="card-header" id="heading-gameweek-{{ $gameweek->id }}">
                <h5 class="mb-0">
                    <button class="btn btn-link w-100 text-primary text-left" type="button"
                            data-toggle="collapse" data-target="#collapse-gameweek-{{ $gameweek->id }}"
                            aria-expanded="true" aria-controls="collapse-gameweek-{{ $gameweek->id }}">
                        {{ $gameweek->name }}
                        <i class="ni ni-bold-down float-right"></i>
                        <span class="float-right mr-5">
                            {{ $gameweek->deadline_at->format('d.m H:i') }}
                        </span>
                    </button>
                </h5>
            </div>
            <div id="collapse-gameweek-{{ $gameweek->id }}"
                 class="collapse"
                 aria-labelledby="heading-gameweek-{{ $gameweek->id }}">
                @include('fixtures.index.table', ['gameweek' => $gameweek])
            </div>
        </div>
    @endforeach
</div>

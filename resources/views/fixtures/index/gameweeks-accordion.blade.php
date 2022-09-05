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
                    </button>
                </h5>
            </div>
            <div id="collapse-gameweek-{{ $gameweek->id }}"
                 class="collapse @if($gameweek->is_current)show @endif"
                 aria-labelledby="heading-gameweek-{{ $gameweek->id }}">
                @include('fixtures.index.table', ['gameweek' => $gameweek])
            </div>
        </div>
    @endforeach
</div>
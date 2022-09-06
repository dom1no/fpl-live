@php($player ??= optional())
@php($homeTeam = $fixture->homeTeam)
@php($awayTeam = $fixture->awayTeam)
<a href="{{ route('fixtures.show', $fixture) }}" @class([$linkClass ?? null])>
    <span @class(['d-inline-block', 'text-underline' => $homeTeam->id == $player->team_id])>
        {{ ($showShortNames ?? false) ? $homeTeam->short_name : $homeTeam->name }}
    </span>
    @if ($fixture->isFeature())
        -
    @else
        {{ $fixture->score_formatted }}
    @endif
    <span @class(['d-inline-block', 'text-underline' => $awayTeam->id == $player->team_id])>
        {{ ($showShortNames ?? false) ? $awayTeam->short_name : $awayTeam->name }}
    </span>
</a>

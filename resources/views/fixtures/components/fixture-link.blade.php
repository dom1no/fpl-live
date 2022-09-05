@php($player ??= optional())
@php($homeTeam = $fixture->homeTeam)
@php($awayTeam = $fixture->awayTeam)
<a href="{{ route('fixtures.show', $fixture) }}">
    <span class="@if ($homeTeam->id == $player->team_id) text-underline @endif">
        {{ ($showShortNames ?? false) ? $homeTeam->short_name : $homeTeam->name }}
    </span>
    @if ($fixture->isFeature())
        -
    @else
        {{ $fixture->score_formatted }}
    @endif
    <span class="@if ($awayTeam->id == $player->team_id) text-underline @endif">
        {{ ($showShortNames ?? false) ? $awayTeam->short_name : $awayTeam->name }}
    </span>
</a>

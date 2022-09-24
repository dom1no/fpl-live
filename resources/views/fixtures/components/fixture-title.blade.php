@php
    $player ??= optional();
    $homeTeam ??= $fixture->homeTeam;
    $awayTeam ??= $fixture->awayTeam;
@endphp

<span @class(['fixture-title-home', 'text-underline' => $homeTeam->id == $player->team_id])>
    {{ ($showShortNames ?? false) ? $homeTeam->short_name : $homeTeam->name }}
</span>

<span class="fixture-title-score">
    @if ($fixture->isFeature())
        -
    @else
        {{ $fixture->score_formatted }}
    @endif
</span>

<span @class(['fixture-title-away', 'text-underline' => $awayTeam->id == $player->team_id])>
    {{ ($showShortNames ?? false) ? $awayTeam->short_name : $awayTeam->name }}
</span>

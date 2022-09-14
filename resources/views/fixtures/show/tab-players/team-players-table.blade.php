@php use App\Models\Enums\PlayerPointAction; @endphp

<table class="table align-items-center">
    <thead class="thead-light">
    <tr>
        <th scope="col">Игрок</th>
        <th scope="col" class="px-2">Очки</th>
        @auth
            <th scope="col" class="pl-3 pr-1">У кого</th>
        @endauth
        <th scope="col" class="d-none d-md-block">BPS</th>
    </tr>
    </thead>
    <tbody>
    @foreach($players as $player)
        @php
            $playerStats = $player->gameweekStats ?? optional();
            $playerPoints = $player->points->where('gameweek_id', $fixture->gameweek_id);
        @endphp
        <tr @class(['accordion-toggle', 'pointer', 'bg-translucent-secondary' => auth()->check() && $player->managerPicks->contains('manager_id', auth()->id())])
            data-toggle="modal" data-target="#player-{{ $player->id }}"
        >
            <td class="text-truncate" style="max-width: 40vw;">
                {{ $player->name }}
                @for ($i = 0; $i < $playerStats->goals_scored; $i++)
                    <i class="fas fa-futbol"></i>
                @endfor
                @for ($i = 0; $i < $playerStats->assists; $i++)
                    <i class="fab fa-adn"></i>
                @endfor
                @for ($i = 0; $i < $playerStats->yellow_cards; $i++)
                    <i class="fas fa-square text-yellow"></i>
                @endfor
                @for ($i = 0; $i < $playerStats->red_cards; $i++)
                    <i class="fab fa-square icon-shape-danger"></i>
                @endfor
                @for ($i = 0; $i < $playerStats->own_goals; $i++)
                    <i class="fas fa-futbol text-danger"></i>
                @endfor
                <br>
                <span class="opacity-7 text-xs">
                    {{ $player->position->value }}
                </span>
                <span class="d-block d-md-none opacity-7 text-xs">
                    BPS: {{ $playerStats->bps ?: '-' }}
                </span>
            </td>
            <td class="px-2">
                {{ $player->points_sum ?: '-' }}

                @if ($bonus = $playerPoints->whereIn('action', [PlayerPointAction::BONUS, PlayerPointAction::PREDICTION_BONUS])->first())
                    <span class="opacity-{{ $bonus->action === PlayerPointAction::PREDICTION_BONUS ? '5' : '7' }}">
                        (+{{ $bonus->points }})
                    </span>
                @endif
            </td>
            @auth
                <td class="pl-3 pr-1">
                    <ul class="pl-2 pr-0 mb-0">
                        @foreach($player->managerPicks->sortByDesc('multiplier') as $pick)
                            <li @class(['text-light' => $pick->multiplier == 0])">
                                {{ $pick->manager->name }}
                                @if ($pick->is_captain)
                                    <i class="fas fa-copyright"></i>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </td>
            @endauth
            <td class="d-none d-md-table-cell">
                {{ $playerStats->bps ?: '-' }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@php use App\Models\Enums\PlayerPointAction; @endphp
<div class="table-responsive">
    <table class="table align-items-center">
        <thead class="thead-light">
        <tr>
            <th scope="col">Игрок</th>
            <th scope="col">Очки</th>
            <th scope="col">BPS</th>
            <th scope="col">У кого в команде</th>
        </tr>
        </thead>
        <tbody>

        @foreach($players->sortByDesc('points_sum') as $player)
            @php($playerStats = $player->gameweekStats ?? optional())
            <tr data-toggle="collapse" data-target="#player-points-explain-{{ $player->id }}"
                class="accordion-toggle">
                <td>
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
                    <span class="opacity-7">
                        {{ $player->position->value }}
                    </span>
                </td>
                <td>
                    {{ $player->points_sum ?: '-' }}

                    @if ($predictionBonus = $player->points->firstWhere('action', PlayerPointAction::PREDICTION_BONUS))
                        <span class="opacity-7">
                            (+{{ $predictionBonus->points }})
                        </span>
                    @endif

                    @if($player->points->isNotEmpty() && $playerStats->minutes > 0)
                        <div class="dropup d-none d-md-inline-block">
                            <div class="badge badge-sm badge-pill badge-primary badge-icon" href="javascript:;" role="button"
                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-question"></i>
                            </div>
                            <div class="dropdown-menu">
                                @include('fixtures.components.player-points-explain-list')
                            </div>
                        </div>
                    @endif
                </td>
                <td>
                    {{ $playerStats->bps ?: '-' }}
                    @if ($bonus = $player->points->firstWhere('action', PlayerPointAction::BONUS))
                        <span class="opacity-8">
                            (+{{ $bonus->points }})
                        </span>
                    @endif
                </td>
                <td>
                    <ul class="p-3">
                        @foreach($player->managerPicks->sortByDesc('multiplier') as $pick)
                            <li class="@if($pick->multiplier == 0)text-light @endif">
                                {{ $pick->manager->name }}
                                @if ($pick->is_captain)
                                    <i class="fas fa-copyright"></i>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            <tr class="collapse d-print-block d-md-none" id="player-points-explain-{{ $player->id }}">
                <td colspan="4" class="p-0">
                    @include('fixtures.components.player-points-explain-list')
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

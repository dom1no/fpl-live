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
            <tr>
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
                    {{ $player->position->value }}
                </td>
                <td>
                    {{ $player->points_sum ?: '-' }}

                    @if ($player->points->doesntContain('action', PlayerPointAction::BONUS) && $bpsTopPlayers->has($player->id))
                        (+{{ $bpsTopPlayers->get($player->id) }})
                    @endif

                    @if($player->points->isNotEmpty() && $playerStats->minutes > 0)
                        <div class="dropup">
                            <div class="badge badge-sm badge-pill badge-primary badge-icon" href="javascript:;" role="button"
                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-question"></i>
                            </div>
                            <div class="dropdown-menu">
                                <table class="table align-items-center">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Действие</th>
                                        <th scope="col">Результат</th>
                                        <th scope="col">Очки</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($player->points as $point)
                                        <tr>
                                            <td>{{ $point->action->title() }}</td>
                                            <td>{{ $point->value }}</td>
                                            <td>{{ $point->points }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </td>
                <td>
                    {{ $playerStats->bps ?: '-' }}
                    @if ($bpsTopPlayers->has($player->id))
                        (+{{ $bpsTopPlayers->get($player->id) }})
                    @endif
                </td>
                <td>
                    <ul>
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
        @endforeach
        </tbody>
    </table>
</div>

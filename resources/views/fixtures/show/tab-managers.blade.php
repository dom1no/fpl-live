<div class="row">
    <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2">
        <div class="card">
            <div class="card-body p-0">
                <table class="table align-items-center">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" class="pl-4 pr-2">Менеджер</th>
                        <th scope="col" class="px-2">Очки</th>
                        <th scope="col" class="pl-3 pr-1">За кого</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($managersPicks as $managerPicks)
                        @php($manager = $managerPicks->first()->manager)
                        <tr>
                            <td class="pl-4 pr-2 text-truncate" style="max-width: 40vw;">{{ $manager->name }}</td>
                            <td class="px-2">{{ $managerPicks->points_sum }}</td>
                            <td class="pl-3 pr-1">
                                <ul class="pl-2 pr-0">
                                    @foreach($managerPicks->sortByDesc('points') as $pick)
                                        @php($player = $players->get($pick->player_id))
                                        <li class="@if($pick->multiplier == 0)text-light @endif">
                                            {{ $player->name }}
                                            @if ($pick->is_captain)
                                                <i class="fas fa-copyright"></i>
                                            @endif
                                            @if(!$fixture->isFeature())
                                                ({{ $pick->points }})
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
        </div>
    </div>
</div>

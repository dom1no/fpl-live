<div class="col-sm-12">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-items-center">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Менеджер</th>
                        <th scope="col">Очки</th>
                        <th scope="col">За кого</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($managersPicks->sortByDesc('points_sum') as $managerPicks)
                        @php($manager = $managerPicks->first()->manager)
                        <tr>
                            <td>{{ $manager->name }}</td>
                            <td>{{ $managerPicks->points_sum }}</td>
                            <td>
                                <ul>
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

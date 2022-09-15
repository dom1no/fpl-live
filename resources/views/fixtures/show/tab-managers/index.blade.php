<div class="row">
    <div class="col-sm-10 offset-sm-1">
        <div class="card shadow">
            <div class="card-body p-0">
                <table class="table align-items-center">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" class="pl-4 pr-2">Менеджер</th>
                        <th scope="col" class="px-2">Очки</th>
                        <th scope="col" class="pl-3 pr-1">Игроки</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($managersPicks as $managerPicks)
                        @php($manager = $managerPicks->first()->manager)
                        <tr @class(['font-weight-bold bg-light' => auth()->user()->is($manager)])>
                            <td class="pl-4 pr-2 text-truncate" style="max-width: 40vw;">{{ $manager->name }}</td>
                            <td class="px-2">{{ $managerPicks->points_sum }}</td>
                            <td class="pl-3 pr-1">
                                @include('components.picks-list', [
                                    'picks' => $managerPicks,
                                ])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

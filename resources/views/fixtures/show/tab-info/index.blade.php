<div class="row">
    <div class="col-sm-10 offset-sm-1">
        <div class="card">
            <div class="card-body p-0">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th class="text-right border-right" style="width: 50%;">{{ $homeTeam->name }}</th>
                        <th class="text-left" style="width: 50%;">{{ $awayTeam->name }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @include('fixtures.show.tab-info.stats-team-players', [
                        'statsKey' => 'goals_scored',
                        'statsName' => 'Голы',
                    ])
                    @include('fixtures.show.tab-info.stats-team-players', [
                        'statsKey' => 'assists',
                        'statsName' => 'Голевые передачи',
                    ])
                    @include('fixtures.show.tab-info.stats-team-players', [
                        'statsKey' => 'own_goals',
                        'statsName' => 'Автоголы',
                    ])
                    @include('fixtures.show.tab-info.stats-team-players', [
                        'statsKey' => 'yellow_cards',
                        'statsName' => 'Желтые карточки',
                    ])
                    @include('fixtures.show.tab-info.stats-team-players', [
                        'statsKey' => 'red_cards',
                        'statsName' => 'Красные карточки',
                    ])
                    @include('fixtures.show.tab-info.stats-team-players', [
                        'statsKey' => 'saves',
                        'statsName' => 'Сейвы',
                    ])
                    @include('fixtures.show.tab-info.stats-team-players', [
                        'statsKey' => 'bonus',
                        'statsName' => 'Бонусы',
                    ])
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

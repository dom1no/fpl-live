@extends('layouts.app')

@section('content')
    <p class="display-3">{{ $gameweek->name }}</p>
    <div class="row">
        <div class="col-sm-12">
            <div class="card m-2">
                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Менеджер</th>
                            <th scope="col">GW Очки</th>
                            <th scope="col" class="d-none d-sm-block">Всего очков</th>
                            <th scope="col">Сыграло игроков</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($managers as $manager)
                            @php($playedPicks = $playedPicksByManagers->get($manager->id))
                            @php($playedPicksMain = $playedPicks->where('multiplier', '>', 0))
                            <tr>
                                <td>{{ $manager->name }}</td>
                                <td>
                                    {{ $manager->picks->sum('points') }}
                                    <span class="d-block d-md-none">
                                        ({{ $manager->total_points }})
                                    </span>
                                </td>
                                <td class="d-none d-sm-table-cell">{{ $manager->total_points }}</td>
                                <td>
                                    {{ $playedPicksMain->count() }} ({{ $playedPicks->count() }})
                                    <br>
                                    {{ price_formatted($playedPicksMain->sum('player.price')) }} ({{ price_formatted($playedPicks->sum('player.price')) }})
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

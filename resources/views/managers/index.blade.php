@extends('layouts.app')

@section('content')
    <p class="display-3">{{ $gameweek->name }}</p>
    <div class="row">
        <div class="col-sm-12">
            <div class="card m-2">
                <div class="table-responsive table-hover">
                    <table class="table align-items-center">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Менеджер</th>
                            <th scope="col">GW Очки</th>
                            <th scope="col">Всего очков</th>
                            <th scope="col">Сыграло игроков</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($managers as $manager)
                            @php($playedPicks = $playedPicksByManagers->get($manager->id))
                            @php($playedPicksMain = $playedPicks->where('multiplier', '>', 0))
                            <tr data-toggle="collapse" data-target="#manager-team-{{ $manager->id }}"
                                class="accordion-toggle">
                                <td>{{ $manager->name }}</td>
                                <td>
                                    {{ $manager->picks->sum('points') }}
                                </td>
                                <td>{{ $manager->total_points }}</td>
                                <td>
                                    {{ $playedPicksMain->count() }} ({{ $playedPicks->count() }})
                                    |
                                    {{ price_formatted($playedPicksMain->sum('player.price')) }}
                                    ({{ price_formatted($playedPicks->sum('player.price')) }})
                                </td>
                            </tr>
                            <tr class="collapse" id="manager-team-{{ $manager->id }}">
                                <td colspan="4" class="p-0">
                                    @include('managers.components.manager-team-table')
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

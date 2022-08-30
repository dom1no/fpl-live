@extends('layouts.app')

@section('content')
    <p class="display-3">{{ $gameweek->name }}</p>
    <div class="row">
        @foreach($managers as $manager)
            <div class="col-sm-4">
                <div class="card m-2">
                    <div class="card-header">
                        <h2>{{ $manager->name }}</h2>
                        <p>GW очки: {{ $manager->picks->sum('points') }}</p>
                        <p>Всего очков: {{ $manager->total_points }}</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Игрок</th>
                                    <th scope="col">Цена</th>
                                    <th scope="col">GW Очки</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($manager->picks as $pick)
                                    @php($player = $pick->player)
                                    <tr>
                                        <td>
                                            {{ $player->name }}
                                            @if ($pick->is_captain)
                                                <i class="fas fa-copyright"></i>
                                            @endif
                                            <br>
                                            {{ $player->team->short_name }} {{ $player->position->value }}
                                        </td>
                                        <td>
                                            {{ $player->price }}
                                        </td>
                                        <td>
                                            {{ $pick->points }}
                                        </td>
                                    </tr>
                                    @if ($loop->iteration === 11)
                                        <tr>
                                            <td colspan="3" class="text-left lead">Запас</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

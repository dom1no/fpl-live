@extends('layouts.app')

@section('content')
    <p class="display-3">{{ $gameweek->name }}</p>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <table class="table table-hover align-items-center">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" class="px-3">#</th>
                        <th scope="col" class="pl-2">Менеджер</th>
                        <th scope="col">Очки</th>
                        <th scope="col">Всего</th>
{{--                            <th scope="col">Сыграло(играет) игроков</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($managers as $manager)
                        @php($playedPicksCount = $playedPicksCountByManagers->get($manager->id))

                        <tr data-toggle="collapse" data-target="#manager-team-{{ $manager->id }}"
                            class="manager-table-row collapsed">
                            <td style="width: 20px;" class="px-3">
                                {{ $loop->iteration }}
                            </td>
                            <td class="pl-2">
                                {{ $manager->name }}
                                @foreach($manager->chips as $chip)
                                    <br class="d-block d-sm-none">
                                    <span class="badge badge-light">
                                        {{ $chip->type->title() }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                {{ $manager->gameweek_points }}
                                @if ($transfersCost = $manager->paid_transfers_count * 4)
                                    <span class="opacity-7">
                                        (-{{ $transfersCost }})
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $manager->total_points }}
                            </td>
{{--                                <td>--}}
{{--                                    Сыграло(играет) игроков:--}}
{{--                                    {{ $playedPicksCount['played'] }}--}}
{{--                                    @if($playedPicksCount['playing'])--}}
{{--                                        ({{ $playedPicksCount['playing'] }})--}}
{{--                                    @endif--}}
{{--                                </td>--}}
                        </tr>
                        <tr class="collapse" id="manager-team-{{ $manager->id }}">
                            <td colspan="100%" class="p-0">
                                @include('managers.components.team')
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

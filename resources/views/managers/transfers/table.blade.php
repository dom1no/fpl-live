@php use App\Models\Enums\ChipType;use App\Models\ManagerPick; @endphp

<div class="table-responsive">
    <table class="table align-items-center">
        <thead class="thead-light">
        <tr>
            <th scope="col" class="px-3">#</th>
            <th scope="col" class="pl-2">Менеджер</th>
            <th scope="col" style="width: 30%;">Ушли</th>
            <th scope="col" style="width: 30%;">Пришли</th>
            <th scope="col">Очки</th>
            <th scope="col">Всего</th>
        </tr>
        </thead>
        <tbody>
        @foreach($managers as $manager)
            <tr @class(['font-weight-bold bg-translucent-secondary' => auth()->user()->is($manager)])>
                <td style="width: 20px;" class="px-3">
                    {{ $loop->iteration }}
                </td>
                <td class="pl-2">
                    <a href="{{ route('managers.show', ['manager' => $manager, 'gameweek' => $gameweek->id]) }}">
                        {{ $manager->name }}
                    </a>
                    @include('managers.components.chips-badges', ['chips' => $manager->chips, 'withMobileBr' => true])
                </td>
                <td style="width: 30%; min-width: 150px;" class="px-1">
                    @include('managers.transfers.players-list', ['isIn' => false])
                </td>
                <td style="width: 30%; min-width: 150px;" class="px-1">
                    @include('managers.transfers.players-list', ['isIn' => true])
                </td>
                <td>
                    {{ $manager->gameweekPointsHistory->points }}
                    @if ($transfersCost = $manager->gameweekPointsHistory->transfers_cost)
                        <span class="opacity-7">
                        (-{{ $transfersCost }})
                    </span>
                    @endif
                </td>
                <td>
                    {{ $manager->gameweekPointsHistory->total_points }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


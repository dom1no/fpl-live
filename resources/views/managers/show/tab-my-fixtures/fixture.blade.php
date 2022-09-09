<table class="table">
    <thead
        @class(['thead-light', 'text-center', 'font-weight-bold' => $fixture->isFinished()])
    >
    <tr>
        <th colspan="100%" class="clickable">
            <a href="{{ route('fixtures.show', $fixture) }}" class="">
                {{ $fixture->kickoff_time->format('d.m H:i') }}
                <br>
                <span class="small">{{ $fixture->status_text }}</span>
            </a>
        </th>
    </tr>
    <tr>
        <th class="w-50 border-right">
            {{ $fixture->homeTeam->name }}
            <span class="float-right">{{ $fixture->homeTeam->pivot->score }}</span>
        </th>
        <th class="w-50">
            <span class="float-left">{{ $fixture->awayTeam->pivot->score }}</span>
            {{ $fixture->awayTeam->name }}
        </th>
    </tr>
    </thead>
    <tbody class="bg-white">
    <tr>
        <td class="w-50 border-right">
            @include('components.picks-list', ['picks' => $homeTeamPicks, 'rtl' => true])
        </td>
        <td class="w-50">
            @include('components.picks-list', ['picks' => $awayTeamPicks])
        </td>
    </tr>
    </tbody>
</table>

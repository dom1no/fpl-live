<div class="table-responsive">
    <table class="table">
        <tbody>
        @foreach($gameweek->fixtures->groupBy(fn($fixture) => $fixture->kickoff_time->day) as $dayFixtures)
            <tr>
                <td colspan="3">
                    {{ $dayFixtures->first()->kickoff_time->format('d.m.Y') }}
                </td>
            </tr>
            @foreach($dayFixtures as $fixture)
                <tr class="@if($fixture->isFinished())font-weight-bold @endif">
                    <td>
                        <a href="{{ route('fixtures.show', $fixture) }}">
                            {{ $fixture->homeTeam->name }}
                            @if ($fixture->isFeature())
                                -
                            @else
                                {{ $fixture->homeTeam->pivot->score }}:{{ $fixture->awayTeam->pivot->score }}
                            @endif
                            {{ $fixture->awayTeam->name }}
                        </a>
                    </td>
                    <td>
                        @if ($fixture->isInProgress())
                            @if ($fixture->minutes)
                                {{ $fixture->minutes }}'
                            @else
                                @php
                                    //TODO: fpl не отдает сыгранные минуты в реал.времени
                                    $diffInMinutes = now()->diffInMinutes($fixture->kickoff_time);
                                    if ($diffInMinutes > 45 && $diffInMinutes < 60) {
                                        $diffInMinutes = 45;
                                    } elseif ($diffInMinutes >= 60) {
                                        $diffInMinutes -= 15;
                                    }
                                @endphp
                                ~{{ $diffInMinutes }}'
                            @endif
                        @elseif($fixture->isFeature())
                            Не начался
                        @else
                            Завершен
                        @endif
                    </td>
                    <td class="pl-5">
                        {{ $fixture->kickoff_time->format('H:i') }}
                    </td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>

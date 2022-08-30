<div class="table-responsive">
    <table class="table">
        <tbody>
        @foreach($gameweek->fixtures as $fixture)
            <tr>
                <td class="pl-5">
                    {{ $fixture->kickoff_time->format('d.m.Y H:i') }}
                </td>
                <td>
                    <a href="{{ route('fixtures.show', $fixture) }}">
                        {{ $fixture->homeTeam->name }}
                        @if ($fixture->isFeature())
                            -
                        @else
                            {{ $fixture->home_team_score }}:{{ $fixture->away_team_score }}
                        @endif
                        {{ $fixture->awayTeam->name }}
                    </a>
                </td>
                <td>
                    @if ($fixture->isInProgress())
                        {{ $fixture->minutes }}'
                    @elseif($fixture->isFeature())
                        Не начался
                    @else
                        Завершен
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

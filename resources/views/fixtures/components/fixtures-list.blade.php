<table class="table">
    <tbody>
    @foreach($gameweek->fixtures->groupBy(fn($fixture) => $fixture->kickoff_time->day) as $dayFixtures)
        <tr>
            <td colspan="100%">
                {{ $dayFixtures->first()->kickoff_time->format('d.m.Y') }}
            </td>
        </tr>
        @foreach($dayFixtures as $fixture)
            <tr class="@if($fixture->isFinished())font-weight-bold @endif">
                <td>
                    @include('components.fixture-link')
                </td>
                <td>
                    <span class="d-block d-md-none font-weight-normal">
                        {{ $fixture->kickoff_time->format('H:i') }}
                    </span>
                    @if ($fixture->isInProgress())
                        {{ $fixture->minutes }}'
                    @elseif($fixture->isFeature())
                        Не начался
                    @else
                        Завершен
                    @endif
                </td>
                <td class="pl-5 d-none d-md-table-cell">
                    {{ $fixture->kickoff_time->format('H:i') }}
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

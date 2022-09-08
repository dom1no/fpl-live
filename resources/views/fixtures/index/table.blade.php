<table class="table">
    <tbody>
    @foreach($fixtures->groupBy(fn($fixture) => $fixture->kickoff_time->day) as $dayFixtures)
        <tr>
            <td colspan="100%" class="py-2 bg-secondary">
                {{ $dayFixtures->first()->kickoff_time->format('d.m.Y') }}
            </td>
        </tr>
        @foreach($dayFixtures as $fixture)
            <tr @class(['font-weight-bold' => $fixture->isFinished()])>
                <td>
                    @include('fixtures.components.fixture-link')
                </td>
                <td>
                    <span class="d-block d-md-none font-weight-normal">
                        {{ $fixture->kickoff_time->format('H:i') }}
                    </span>
                    {{ $fixture->status_text }}
                </td>
                <td class="pl-5 d-none d-md-table-cell">
                    {{ $fixture->kickoff_time->format('H:i') }}
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

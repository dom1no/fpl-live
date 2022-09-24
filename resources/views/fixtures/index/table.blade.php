<table class="table">
    <tbody>
    @foreach($fixtures->groupBy(fn ($fixture) => $fixture->kickoff_time->day) as $dayFixtures)
        <tr>
            <td colspan="100%" class="py-2 bg-secondary">
                {{ $dayFixtures->first()->kickoff_time->format('d.m.Y') }}
            </td>
        </tr>
        @foreach($dayFixtures as $fixture)
            <tr @class(['font-weight-bold' => $fixture->isFinished()])>
                <td class="text-center px-2">
                    @if ($fixture->isFeature())
                        <span class="d-block d-md-none">
                            {{ $fixture->kickoff_time->format('H:i') }}
                        </span>
                    @else
                        <span class="d-block d-md-none text-muted">
                            {{ $fixture->status_text }}
                        </span>
                    @endif

                    @include('fixtures.components.fixture-link', ['linkClass' => 'fixture-title-centered text-lg'])

                    @if (!$fixture->isFeature())
                        <span class="d-block text-muted text-xs">
                            {{ $fixture->xg_formatted }}
                        </span>
                    @endif
                </td>
                <td class="d-none d-md-table-cell text-center">
                    {{ $fixture->kickoff_time->format('H:i') }}
                    <br>
                    {{ $fixture->status_text }}
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

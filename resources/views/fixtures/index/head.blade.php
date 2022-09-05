<p class="display-3">
    {{ $currentGameweek->name }}
    <a href="{{ route('fixtures.sync') }}" class="btn btn-primary btn-md float-right">
        Обновить данные
    </a>
</p>

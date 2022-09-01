<table class="table align-items-center">
    <thead class="thead-light">
    <tr>
        <th scope="col">Действие</th>
        <th scope="col">Результат</th>
        <th scope="col">Очки</th>
    </tr>
    </thead>
    <tbody>
    @foreach($player->points as $point)
        <tr>
            <td>{{ $point->action->title() }}</td>
            <td>{{ $point->value }}</td>
            <td>{{ $point->points }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

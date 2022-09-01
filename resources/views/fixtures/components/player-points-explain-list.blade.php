<div class="table-responsive">
    <table class="table align-items-center">
        <thead class="thead-light">
        <tr>
            <th scope="col" style="width: 10%;">Действие</th>
            <th scope="col" style="width: 5%;">Результат</th>
            <th scope="col" style="width: 5%;">Очки</th>
            <th scope="col" style="width: 5%;"></th>
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
</div>

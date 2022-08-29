@extends('layouts.app')

@section('content')
    <div class="table-responsive">
        <table class="table align-items-center">
            <thead class="thead-light">
            <tr>
                <th scope="col">Игрок</th>
                <th scope="col">Позиция</th>
                <th scope="col">Команда</th>
                <th scope="col">Цена</th>
                <th scope="col">Капитан</th>
            </tr>
            </thead>
            <tbody>
            @foreach($picks as $pick)
                @php($player = $pick->player)
                <tr>
                    <td>
                        {{ $player->name }}
                    </td>
                    <td>
                        {{ $player->position->value }}
                    </td>
                    <td>
                        {{ $player->team->name }}
                    </td>
                    <td>
                        {{ $player->price }}
                    </td>
                    <td>
                        {{ $pick->is_captain ? 'Да' : 'Нет' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

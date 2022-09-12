@once('modal-player-' . $player->id)
    @push('modals')
        <div class="modal fade" id="player-{{ $player->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header px-3 pt-3 pb-0">
                        <div class="d-flex align-items-center ml--2">
                            <img src="{{ $player->getPhotoUrl() }}" class="player-photo mr-2">
                            <div class="modal-title">
                                <span class="display-4 lh-120">{{ $player->full_name }}</span>
                                <br>
                                <span class="text-muted text-sm">
                                    {{ $player->team->name }}
                                </span>
                                <br>
                                <span class="text-muted text-xs">
                                    {{ $player->position->title() }}
                                </span>
                                <br>
                                <span class="text-muted text-xs">
                                    {{ price_formatted($player->price) }}
                                </span>
                                {{-- TODO: fixture --}}
                            </div>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <table class="table align-items-center m-0">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Действие</th>
                                <th scope="col" class="px-1 px-md-4">Результат</th>
                                <th scope="col" class="pl-1 pl-md-4">Очки</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($player->points->sortByDesc('points') as $point)
                                <tr>
                                    <td>{{ $point->action->title() }}</td>
                                    <td class="px-1 px-md-4">{{ $point->value }}</td>
                                    <td class="pl-1 pl-md-4">{{ $point->points }}</td>
                                </tr>
                            @endforeach
                            <tr class="font-weight-bold">
                                <td></td>
                                <td class="px-1 px-md-4">
                                    Всего
                                </td>
                                <td class="pl-1 pl-md-4">{{ $player->points->sum('points') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endpush
@endonce

@if ($player->isNotOk())
    @svg($player->status->icon(), [
        'class' => "text-{$player->status->color($player)} " . ($class ?? ''),
        'data-toggle' => 'tooltip',
        'data-title' => nl2br($player->status_text),
        'data-html' => 'true',
        'width' => 16,
    ])
@endif

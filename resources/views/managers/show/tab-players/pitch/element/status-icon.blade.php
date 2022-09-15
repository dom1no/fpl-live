@svg($player->status->icon(), [
    'class' => 'pitch-row-unit-element-status-icon text-' . $player->status->color($player),
    'data-toggle' => 'tooltip',
    'data-title' => $player->status_text,
])

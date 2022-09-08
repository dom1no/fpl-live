@svg('phosphor-arrows-down-up-bold', [
    'class' => 'pitch-row-unit-element-autosub-icon rounded'
        . (($isIn ?? false) ? ' bg-translucent-info text-white' : '')
        . (($isOut ?? false) ? ' text-danger' : '')
])

<?php

namespace App\Models;

use App\Models\Enums\ChipType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagerChip extends Model
{
    use ForGameweek;

    protected $fillable = [
        'manager_id',
        'gameweek_id',
        'type',
    ];

    protected $casts = [
        'type' => ChipType::class,
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }
}

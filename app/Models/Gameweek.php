<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Gameweek extends Model
{
    protected $fillable = [
        'name',
        'deadline_at',
        'is_finished',
        'is_previous',
        'is_current',
        'is_next',
        'fpl_id',
    ];

    protected $dates = [
        'deadline_at',
    ];

    public function fixtures(): HasMany
    {
        return $this->hasMany(Fixture::class);
    }

    public static function getCurrent(): static
    {
        return Cache::remember(
            'current_gameweek',
            now()->minutes(1),
            fn () => static::where('is_current', true)->first()
        );
    }

    public function scopeFinishedOrCurrent(Builder $query): void
    {
        $query->where(function (Builder $query) {
            $query->where('is_finished', true)
                ->orWhere('is_current', true);
        });
    }
}

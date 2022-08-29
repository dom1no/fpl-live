<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public static function getCurrent(): static
    {
        return static::where('is_current', true)->first();
    }
}

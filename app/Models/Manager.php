<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Manager extends Authenticatable
{
    public const DEFAULT_PASSWORD = 'qwerty';

    use Notifiable;

    protected $fillable = [
        'name',
        'command_name',
        'total_points',
        'fpl_id',
        'telegram_username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function picks(): HasMany
    {
        return $this->hasMany(ManagerPick::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(ManagerTransfer::class);
    }

    public function autoSubs(): HasMany
    {
        return $this->hasMany(ManagerAutoSub::class);
    }

    public function chips(): HasMany
    {
        return $this->hasMany(ManagerChip::class);
    }

    public function routeNotificationForTelegram(): ?string
    {
        return $this->telegram_username;
    }
}

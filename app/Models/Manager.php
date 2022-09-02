<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Manager extends Model
{
    use Notifiable;

    protected $fillable = [
        'name',
        'command_name',
        'total_points',
        'fpl_id',
        'telegram_username',
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

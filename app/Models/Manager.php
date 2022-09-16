<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read int|null $gameweek_points
 */
class Manager extends Authenticatable
{
    public const DEFAULT_PASSWORD = 'qwerty';
    public const DEFAULT_TELEGRAM_CHAT_ID = '119785472';

    use Notifiable;
    use HasFactory;

    protected $fillable = [
        'name',
        'command_name',
        'total_points',
        'fpl_id',
        'telegram_username',
        'telegram_chat_id',
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

    public function pointsHistory(): HasMany
    {
        return $this->hasMany(ManagerPointsHistory::class);
    }

    /** use with condition */
    public function gameweekPointsHistory(): HasOne
    {
        return $this->hasOne(ManagerPointsHistory::class)->withDefault([
            'points' => 0,
            'total_points' => 0,
        ]);
    }

    public function routeNotificationForTelegram(): ?string
    {
        return $this->telegram_chat_id;
    }

    public function isAdmin(): bool
    {
        return $this->name === 'Maxim Kuprov';
    }
}

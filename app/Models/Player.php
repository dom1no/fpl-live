<?php

namespace App\Models;

use App\Models\Enums\PlayerPosition;
use App\Models\Enums\PlayerStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Storage;

class Player extends Model
{
    protected $fillable = [
        'name',
        'full_name',
        'position',
        'price',
        'team_id',
        'status',
        'status_comment',
        'status_at',
        'chance_of_playing',
        'returned_at',
        'fpl_id',
        'fot_mob_id',
    ];

    protected $casts = [
        'position' => PlayerPosition::class,
        'status' => PlayerStatus::class,
        'price' => 'float',
    ];

    protected $dates = [
        'status_at',
        'returned_at',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function managerPicks(): HasMany
    {
        return $this->hasMany(ManagerPick::class);
    }

    public function stats(): HasMany
    {
        return $this->hasMany(PlayerStats::class);
    }

    /** use with condition */
    public function gameweekStats(): HasOne
    {
        return $this->hasOne(PlayerStats::class);
    }

    public function points(): HasMany
    {
        return $this->hasMany(PlayerPoint::class);
    }

    public function getFilePhotoName(): string
    {
        return "photo_{$this->id}.png";
    }

    public function getPhotoUrl(): string
    {
        $disk = Storage::disk('player-photos');

        $fileName = $this->getFilePhotoName();

        if (! $disk->exists($fileName)) {
            return $this->team->getShirtUrl(110, 'png', $this->position === PlayerPosition::GOALKEEPER);
        }

        return $disk->url($fileName);
    }

    public function isNotOk(): bool
    {
        return $this->status !== PlayerStatus::OK;
    }

    public function getStatusTextAttribute(): string
    {
        $text = $this->status_comment;
        if ($this->chance_of_playing) {
            $text .= "\nВероятность сыграть: {$this->chance_of_playing}%";
        }
        if ($this->returned_at) {
            $text .= "\nВернется: {$this->returned_at->format('d.m')}";
        }

        return $text;
    }
}

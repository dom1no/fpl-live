<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Storage;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'fpl_id',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function fixtures(): BelongsToMany
    {
        return $this->belongsToMany(Fixture::class)->withPivot('is_home', 'score');
    }

    public function getFileShirtName(int $width, string $ext, bool $isGKP = false): string
    {
        return 'shirt_' . Str::lower($this->short_name) . ($isGKP ? '_gkp' : '') . "-{$width}.{$ext}";
    }

    public function getShirtUrl(int $width, string $ext, bool $isGKP = false): string
    {
        return Storage::disk('shirts')->url($this->getFileShirtName($width, $ext, $isGKP));
    }
}

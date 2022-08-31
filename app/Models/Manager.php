<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manager extends Model
{
    protected $fillable = [
        'name',
        'command_name',
        'total_points',
        'fpl_id',
    ];

    public function picks(): HasMany
    {
        return $this->hasMany(ManagerPick::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(ManagerTransfer::class);
    }
}

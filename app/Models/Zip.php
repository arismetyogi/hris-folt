<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zip extends Model
{
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function karyawans(): HasMany
    {
        return $this->hasMany(Karyawan::class);
    }

    public function apoteks(): HasMany
    {
        return $this->hasMany(Apotek::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apotek extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public function unitBisnis(): BelongsTo
    {
        return $this->belongsTo(UnitBisnis::class);
    }

    public function zip(): BelongsTo
    {
        return $this->belongsTo(Zip::class);
    }

    public function karyawans(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'apotek_id');
    }
}

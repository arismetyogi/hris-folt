<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apotek extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(UnitBisnis::class, 'branch_id', 'id');
    }

    public function zip(): BelongsTo
    {
        return $this->belongsTo(Zip::class);
    }

    public function province()
    {
        return $this->hasOneThrough(Province::class, Zip::class, 'id', 'id', 'zip_id', 'province_code');
    }
    public function karyawans(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'apotek_id');
    }
}

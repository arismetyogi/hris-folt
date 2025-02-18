<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitBisnis extends Model
{
    protected $fillable = [
        'code',
        'name',
        'address',
        'flag',
        'email',
        'entity_code',
        'entity_name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user.branch_id', 'id');
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

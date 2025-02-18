<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    public function karyawans(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'bank_id');
    }
}

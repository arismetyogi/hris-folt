<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    public function karyawans(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'employee_status_id');
    }
}

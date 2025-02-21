<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GradeEselon extends Model
{
    public function karyawans(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'grade_eselon_id');
    }
}

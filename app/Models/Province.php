<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    public function karyawans(): HasMany
    {
        return $this->hasMany(Zip::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    public function karyawans(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }
}

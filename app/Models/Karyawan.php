<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    protected $fillable = [
        'branch_id', 'apotek_id', 'sap_id', 'npp', 'nik', 'name', 'date_of_birth', 'sex', 'address', 'phone', 'religion', 'blood_type', 'zip_id', 'employee_status_id', 'jabatan_id', 'subjabatan_id', 'band_id', 'grade_eselon_id', 'area_id', 'employee_level_id', 'saptitle_id', 'saptitle_name', 'date_hired', 'date_promoted', 'date_last_mutated', 'status_desc_id', 'bpjs_id', 'bpjstk_id', 'insured_member_count', 'bpjs_class', 'contract_document_id', 'contract_sequence_no', 'contract_term', 'contract_start', 'contract_end', 'npwp', 'status_pasangan', 'jumlah_tanggungan', 'pasangan_ditanggung_pajak', 'account_no', 'account_name', 'bank_id', 'recruitment_id', 'pants_size', 'shirt_size'
    ];

    public function apotek(): BelongsTo
    {
        return $this->belongsTo(Apotek::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(UnitBisnis::class);
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    protected $fillable = [
        'bln_thn', 'karyawan_id', '1050_honorarium', 'uang_saku_mb', '3000_lembur', '2580_tunj_lain', 'ujp', '4020_sumbangan_cuti_tahunan', '6500_pot_wajib_koperasi', '6540_pot_pinjaman_koperasi', '6590_pot_ykkkf', '6620_pot_keterlambatan', '6630_pinjaman_karyawan', '6700_pot_bank_mandiri', '6701_pot_bank_bri', '6702_pot_bank_btn', '6703_pot_bank_danamon', '6704_pot_bank_dki', '6705_pot_bank_bjb', '6750_pot_adm_bank_mandiri', '6751_pot_adm_bank_bri', '6752_pot_adm_bank_bjb', '6900_pot_lain',];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }


}

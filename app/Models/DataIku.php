<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataIku extends Model
{
    protected $table = 'data_iku';
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        "perjanjian_kinerja_target_kumulatif",
        "perjanjian_kinerja_realisasi_kumulatif",
        "capaian_kinerja_kumulatif",
        "capaian_kinerja_target_setahun",
        "link_bukti_dukung_capaian",
        "upaya_yang_dilakukan",
        "link_bukti_dukung_upaya_yang_dilakukan",
        "kendala",
        "solusi_atas_kendala",
        "rencana_tidak_lanjut",
        "pic_tidak_lanjut",
        "tenggat_tidak_lanjut",
        "status",
        "upload_by",
        "approve_by",
        "reject_by",
        "triwulan"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'upload_by', 'id');
    }
}

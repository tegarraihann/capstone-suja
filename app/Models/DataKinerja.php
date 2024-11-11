<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataKinerja extends Model
{
    protected $table = 'data_kinerja';
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        "kriteria_kebersihan",
        "tanggal",
        "waktu",
        "foto_before",
        "foto_after",
        "day_id",
        "upload_by"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'upload_by', 'id');
    }

    public function approved_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approve_by');
    }

    public function rejected_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reject_by');
    }

    public function day()
    {
        return $this->belongsTo(Day::class, 'day_id');
    }
}

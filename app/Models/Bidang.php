<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bidang extends Model
{
    protected $table = "bidang";
    protected $primaryLey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'bidang_id', 'id');
    }
}

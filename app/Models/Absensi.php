<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal_absen', 'absen_masuk', 'tidak_masuk', 'status', 'surat_ijin', 'user_id'];

    public function user() {
        return $this->BelongsTo(User::class);
    }
}

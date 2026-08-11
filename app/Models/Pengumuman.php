<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $fillable = [
        'judul',
        'isi',
        'lampiran',
        'target',
        'kelas_id',
        'status',
        'tanggal_publish',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderAkademik extends Model
{
    protected $fillable = [
        'judul',
        'jenis_kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'tahun_akademik',
        'semester',
        'deskripsi',
        'warna',
    ];
}

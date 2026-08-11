<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'wali_kelas',
        'kapasitas',
        'tahun_ajaran',
    ];

    public function jadwalPelajarans()
    {
        return $this->hasMany(JadwalPelajaran::class);
    }
}

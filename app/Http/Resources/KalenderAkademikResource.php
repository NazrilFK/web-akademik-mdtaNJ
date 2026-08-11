<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KalenderAkademikResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'judul' => $this->judul,

            'jenis_kegiatan' => $this->jenis_kegiatan,

            'tanggal_mulai' => \Carbon\Carbon::parse($this->tanggal_mulai)
            ->locale('id')
            ->translatedFormat('d F Y'),

            'tanggal_selesai' => \Carbon\Carbon::parse($this->tanggal_selesai) 
            ->locale('id')
            ->translatedFormat('d F Y'),

            'tahun_akademik' => $this->tahun_akademik,

            'semester' => $this->semester,

            'deskripsi' => $this->deskripsi,

            'warna' => $this->warna,

        ];
    }
}
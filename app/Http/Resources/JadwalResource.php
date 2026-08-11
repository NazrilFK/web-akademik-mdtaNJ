<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JadwalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'jam_mulai' => substr($this->jam_mulai, 0, 5),
            'jam_selesai' => substr($this->jam_selesai, 0, 5),

            'mata_pelajaran' => $this->mataPelajaran->nama_mapel,

            'guru' => $this->guru->name,

            'ruangan' => $this->ruangan,
        ];
    }
}
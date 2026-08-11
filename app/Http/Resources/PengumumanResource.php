<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengumumanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            
            'id' => $this->id,

            'judul' => $this->judul,

            'isi' => $this->isi,

            'tanggal' => Carbon::parse($this->tanggal_publish)
                ->locale('id')
                ->translatedFormat('d F Y'),

            'lampiran' => $this->lampiran
                ? url('storage/'.$this->lampiran)
                : null,

            'target' => $this->target,

        ];
    }
}
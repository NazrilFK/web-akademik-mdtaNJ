<?php

namespace App\Filament\Resources\JadwalPelajarans\Pages;

use App\Filament\Resources\JadwalPelajarans\JadwalPelajaranResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Models\JadwalPelajaran;

class ListJadwalPelajarans extends ListRecords
{
    protected static string $resource = JadwalPelajaranResource::class;

    protected string $view = 'filament.resources.jadwal-pelajarans.pages.list-jadwal';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('New Jadwal Pelajaran'),
        ];
    }

    protected function getViewData(): array
    {
        $allJadwal = JadwalPelajaran::all();

        $schedules = $allJadwal->map(function ($item) {
            
            // 1. DETEKSI MATA PELAJARAN
            $mapelNama = null;
            foreach (['mataPelajaran', 'mata_pelajaran', 'mapel'] as $key) {
                if (isset($item->$key)) {
                    $rel = $item->$key;
                    $mapelNama = is_object($rel) ? ($rel->nama ?? $rel->name ?? $rel->nama_mapel ?? null) : $rel;
                    if ($mapelNama) break;
                }
            }
            if (!$mapelNama) {
                $mapelNama = $item->mata_pelajaran ?? $item->mapel ?? 'Mata Pelajaran';
            }

            // 2. DETEKSI KELAS
            $kelasNama = null;
            if (isset($item->kelas)) {
                $rel = $item->kelas;
                $kelasNama = is_object($rel) ? ($rel->nama ?? $rel->name ?? $rel->nama_kelas ?? null) : $rel;
            }
            if (!$kelasNama) {
                $kelasNama = $item->kelas_id ?? 'Kelas';
            }

            // 3. DETEKSI GURU
            $guruNama = null;
            if (isset($item->guru)) {
                $rel = $item->guru;
                $guruNama = is_object($rel) ? ($rel->nama ?? $rel->name ?? $rel->nama_guru ?? null) : $rel;
            }
            if (!$guruNama) {
                $guruNama = $item->guru_id ?? 'Guru';
            }

            // Format Jam Pelajaran
            $jamMulai = date('H:i', strtotime($item->jam_mulai));
            $jamSelesai = date('H:i', strtotime($item->jam_selesai));
            $timeSlot = $jamMulai . ' - ' . $jamSelesai;

            // 4. PENCOCOKAN WARNA EMERALD, AMBER, INDIGO, PURPLE (Sesuai Gambar Referensi)
            $mapelLower = strtolower($mapelNama);
            $bg = '#e2e8f0'; // Default abu-abu lembut jika tidak cocok

            if (str_contains($mapelLower, 'arab')) {
                $bg = '#10b981'; // Hijau Emerald
            } elseif (str_contains($mapelLower, 'fiqih') || str_contains($mapelLower, 'fiqh')) {
                $bg = '#3b82f6'; // Biru Saphire
            } elseif (str_contains($mapelLower, 'qur') || str_contains($mapelLower, 'al-quran')) {
                $bg = '#bf5af2'; // Ungu Cerah
            } elseif (str_contains($mapelLower, 'akhlak') || str_contains($mapelLower, 'tasawuf')) {
                $bg = '#ff9500'; // Oranye Amber
            } elseif (str_contains($mapelLower, 'tauhid') || str_contains($mapelLower, 'aqidah')) {
                $bg = '#ff3b30'; // Merah Solid
            } elseif (str_contains($mapelLower, 'hadis') || str_contains($mapelLower, 'hadits')) {
                $bg = '#5e5ce6'; // Indigo Royal
            } elseif (str_contains($mapelLower, 'tafsir')) {
                $bg = '#00c7be'; // Cyan Tosca
            }

            return [
                'id' => $item->id,
                'hari' => trim($item->hari),
                'time_slot' => $timeSlot,
                'jam_mulai' => $jamMulai,
                'kelas' => $kelasNama,
                'mapel' => $mapelNama,
                'guru' => $guruNama,
                'ruangan' => $item->ruangan ?? 'Ruangan',
                'bg_color' => $bg,
            ];
        });

        $listKelas = $schedules->pluck('kelas')->unique()->filter()->values()->toArray();
        $listGuru = $schedules->pluck('guru')->unique()->filter()->values()->toArray();
        $timeSlots = $schedules->sortBy('jam_mulai')->pluck('time_slot')->unique()->values()->toArray();

        $legends = $schedules->unique('mapel')->map(function($item) {
            return [
                'mapel' => $item['mapel'],
                'bg_color' => $item['bg_color']
            ];
        })->values()->toArray();

        return [
            'schedules' => $schedules->toArray(),
            'listKelas' => $listKelas,
            'listGuru' => $listGuru,
            'timeSlots' => $timeSlots,
            'legends' => $legends,
        ];
    }
}
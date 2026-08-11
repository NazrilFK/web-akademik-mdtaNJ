<?php

namespace App\Filament\Resources\KalenderAkademiks\Pages;

use App\Filament\Resources\KalenderAkademiks\KalenderAkademikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\KalenderAkademik;
use Carbon\Carbon;

class ListKalenderAkademiks extends ListRecords
{
    protected static string $resource = KalenderAkademikResource::class;

    protected string $view = 'filament.resources.kalender-akademiks.pages.list-kalender';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Jadwal'),
        ];
    }

    protected function getViewData(): array
    {
        // PERBAIKAN 1: Pastikan kolom 'warna' ikut ditarik dari database
        $data = KalenderAkademik::select('id', 'judul', 'tanggal_mulai', 'tanggal_selesai', 'jenis_kegiatan', 'warna')->get();
        
        $events = $data->map(function ($item) {
            // PERBAIKAN 2: Utamakan membaca warna dari database, jika kosong baru pakai fallback teks yang sinkron
            $color = $item->warna ?? match ($item->jenis_kegiatan) {
                'Libur Sekolah' => '#ef4444',
                'Ujian' => '#a855f7',
                'Kegiatan Madrasah' => '#3b82f6',
                'Rapat Guru' => '#f97316',
                'Pembagian Rapor' => '#10b981',
                default => '#6b7280',
            };

            return [
                'id' => $item->id,
                'title' => $item->judul,
                'start' => $item->tanggal_mulai,
                'end' => Carbon::parse($item->tanggal_selesai)->addDay()->format('Y-m-d'), 
                'raw_end' => $item->tanggal_selesai, 
                'color' => $color,
                'backgroundColor' => $color,
                'borderColor' => $color,
            ];
        })->toArray();

        return [
            'events' => $events,
        ];
    }
}
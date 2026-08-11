<?php

use Illuminate\Support\Facades\Route;

use App\Models\KalenderAkademik;

Route::get('/api/kalender-events', function () {
    return KalenderAkademik::all()->map(function ($item) {
        return [
            'id' => $item->id,
            'title' => $item->judul, // Kolom judul kegiatan
            'start' => $item->tanggal_mulai, // Format wajib: YYYY-MM-DD
            'end' => $item->tanggal_selesai ? $item->tanggal_selesai . ' 23:59:59' : $item->tanggal_mulai,
            'allDay' => true,
            'color' => '#3b82f6', 
        ];
    });
})->name('api.kalender.events');
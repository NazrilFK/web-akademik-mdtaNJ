<?php

namespace App\Filament\Resources\MataPelajarans\Widgets;

use App\Models\JadwalPelajaran;
use App\Models\MataPelajaran;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MataPelajaranStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Mata Pelajaran',
                MataPelajaran::count()
            )
            ->description('Seluruh mata pelajaran')
            ->icon('heroicon-o-book-open')
            ->color('primary'),

            Stat::make(
                'Mapel Aktif',
                MataPelajaran::where('status', 'Aktif')->count()
            )
                ->description('Mapel yang digunakan')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make(
                'Pelajaran / Minggu',
                JadwalPelajaran::count()
            )
                ->description('Total jam pelajaran terjadwal')
                ->icon('heroicon-o-calendar-days')
                ->color('warning'),
        ];
    }
}
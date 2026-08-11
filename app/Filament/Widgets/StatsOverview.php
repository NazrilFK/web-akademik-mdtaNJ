<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Pengumuman;
use App\Models\JadwalPelajaran;
use App\Models\KalenderAkademik;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $hariIni = now()->locale('id')->dayName;

        return [
            
            // 1. PENGGUNA SISTEM
            Stat::make('', User::count())
                ->description('Pengguna Sistem')
                ->icon('heroicon-o-users'),

            // 2. JADWAL HARI INI
            Stat::make('', JadwalPelajaran::where('hari', $hariIni)->count())
                ->description('Jadwal Hari Ini')
                ->icon('heroicon-o-clock'),

            // 3. AGENDA AKADEMIK
            Stat::make('', KalenderAkademik::where('tanggal_mulai', '>=', now()->startOfDay())->count())
                ->description('Agenda Academic')
                ->icon('heroicon-o-calendar-days'),

            // 4. PENGUMUMAN
            Stat::make('', Pengumuman::count())
                ->description('Pengumuman')
                ->icon('heroicon-o-megaphone'),

        ];
    }
}
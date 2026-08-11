<?php

namespace App\Filament\Resources\Kelas\Widgets;

use App\Models\Kelas;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KelasStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Kelas', Kelas::count())
                ->description('Jumlah seluruh kelas')
                ->icon('heroicon-o-academic-cap')
                ->color('primary'),
                

            Stat::make('Kelas Aktif', Kelas::count())
                ->description('Kelas yang digunakan')
                ->icon('heroicon-o-building-office')
                ->color('success'),

            Stat::make('Total Siswa', Kelas::sum('kapasitas'))
                ->description('Jumlah seluruh siswa')
                ->icon('heroicon-o-users')
                ->color('warning'),
        ];
    }
}
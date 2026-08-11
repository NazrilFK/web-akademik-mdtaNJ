<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStats extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';
    protected function getColumns(): int
    {
        return 5;
    }
    protected function getStats(): array
    {
        return [

            Stat::make(
                'Guru',
                User::whereIn('role', ['guru', 'admin'])->count()
            )
                ->description('Total Guru')
                ->icon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make(
                'Kelas 1',
                User::where('role', 'siswa')
                    ->where('nama_kelas', 'kelas 1')
                    ->count()
            )
                ->description('Jumlah Siswa')
                ->icon('heroicon-o-academic-cap')
                ->color('success'),

            Stat::make(
                'Kelas 2',
                User::where('role', 'siswa')
                    ->where('nama_kelas', 'kelas 2')
                    ->count()
            )
                ->description('Jumlah Siswa')
                ->icon('heroicon-o-academic-cap')
                ->color('warning'),

            Stat::make(
                'Kelas 3',
                User::where('role', 'siswa')
                    ->where('nama_kelas', 'kelas 3')
                    ->count()
            )
                ->description('Jumlah Siswa')
                ->icon('heroicon-o-academic-cap')
                ->color('info'),

            Stat::make(
                'Kelas 4',
                User::where('role', 'siswa')
                    ->where('nama_kelas', 'kelas 4')
                    ->count()
            )
                ->description('Jumlah Siswa')
                ->icon('heroicon-o-academic-cap')
                ->color('danger'),

        ];
    }
}
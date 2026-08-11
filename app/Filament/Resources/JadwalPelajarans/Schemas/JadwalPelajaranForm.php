<?php

namespace App\Filament\Resources\JadwalPelajarans\Schemas;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\User;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class JadwalPelajaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(
                        Kelas::pluck('nama_kelas', 'id')
                    )
                    ->searchable()
                    ->required(),

                Select::make('mata_pelajaran_id')
                    ->label('Mata Pelajaran')
                    ->options(
                        MataPelajaran::pluck('nama_mapel', 'id')
                    )
                    ->searchable()
                    ->required(),

                Select::make('guru_id')
                    ->label('Guru')
                    ->options(
                        User::where('role', 'Guru')
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->required(),

                Select::make('hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                    ])
                    ->required(),

                TimePicker::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->required(),

                TimePicker::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->required(),

                TextInput::make('ruangan')
                    ->label('Ruangan')
                    ->placeholder('Contoh: Ruang A')
                    ->default(null),

            ]);
    }
}
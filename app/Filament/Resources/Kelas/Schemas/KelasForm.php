<?php

namespace App\Filament\Resources\Kelas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KelasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kelas')
                    ->label('Nama Kelas')
                    ->required()
                    ->maxLength(50),

                Select::make('tingkat')
                    ->label('Tingkat')
                    ->options([
                        '1' => 'Tingkat 1',
                        '2' => 'Tingkat 2',
                        '3' => 'Tingkat 3',
                        '4' => 'Tingkat 4',
                    ])
                    ->required(),

                TextInput::make('wali_kelas')
                    ->label('Wali Kelas')
                    ->maxLength(100),

                TextInput::make('kapasitas')
                    ->label('Kapasitas Siswa')
                    ->numeric()
                    ->required(),

                TextInput::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->placeholder('2025/2026')
                    ->required(),
            ]);
    }
}
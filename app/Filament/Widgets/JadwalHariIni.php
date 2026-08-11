<?php

namespace App\Filament\Widgets;

use App\Models\JadwalPelajaran;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class JadwalHariIni extends TableWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 1;
    protected static ?string $heading = 'Jadwal Hari Ini';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => JadwalPelajaran::query()
                    ->where('hari', now()->locale('id')->dayName)
            )
            ->columns([
                TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas')
                    ->searchable(),

                TextColumn::make('mataPelajaran.nama_mapel')
                    ->label('Mata Pelajaran')
                    ->searchable(),

                TextColumn::make('guru.name')
                    ->label('Guru'),

                TextColumn::make('jam_mulai')
                    ->label('Mulai')
                    ->time(),

                TextColumn::make('jam_selesai')
                    ->label('Selesai')
                    ->time(),

                TextColumn::make('ruangan')
                    ->label('Ruangan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
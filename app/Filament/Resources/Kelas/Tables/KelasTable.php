<?php

namespace App\Filament\Resources\Kelas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KelasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kelas')
                    ->label('Nama Kelas')
                    ->searchable(),

                TextColumn::make('tingkat')
                    ->label('Tingkat')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('wali_kelas')
                    ->label('Wali Kelas')
                    ->searchable(),

                TextColumn::make('kapasitas')
                    ->label('Kapasitas Siswa')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

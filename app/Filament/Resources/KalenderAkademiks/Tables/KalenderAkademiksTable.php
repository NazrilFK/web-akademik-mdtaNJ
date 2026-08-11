<?php

namespace App\Filament\Resources\KalenderAkademiks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KalenderAkademiksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->searchable(),

                TextColumn::make('jenis_kegiatan')
                    ->badge(),

                TextColumn::make('tanggal_mulai')
                    ->date('d M Y'),

                TextColumn::make('tanggal_selesai')
                    ->date('d M Y'),

                TextColumn::make('tahun_akademik'),

                TextColumn::make('semester')
                    ->badge(),
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

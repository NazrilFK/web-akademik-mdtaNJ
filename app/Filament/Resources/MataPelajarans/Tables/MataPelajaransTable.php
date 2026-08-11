<?php

namespace App\Filament\Resources\MataPelajarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MataPelajaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_mapel')
                    ->label('Kode')
                    ->searchable(),

                TextColumn::make('nama_mapel')
                    ->label('Mata Pelajaran')
                    ->searchable(),

                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Nonaktif' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('deskripsi')
                    ->label('Filter Kelas')
                    ->placeholder('Semua Kelas')
                    ->options([
                        'Kelas 1' => 'Kelas 1',
                        'Kelas 2' => 'Kelas 2',
                        'Kelas 3' => 'Kelas 3',
                        'Kelas 4' => 'Kelas 4',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn (Builder $query, $value): Builder => $query->where('deskripsi', 'like', "%{$value}%")
                        );
                    }),
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
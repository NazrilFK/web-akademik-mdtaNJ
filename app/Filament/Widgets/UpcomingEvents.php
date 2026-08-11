<?php

namespace App\Filament\Widgets;

use App\Models\KalenderAkademik;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingEvents extends TableWidget
{
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Kegiatan Akademik Mendatang';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => KalenderAkademik::query()
                    ->whereDate('tanggal_mulai', '>=', now())
                    ->orderBy('tanggal_mulai')
            )
            ->columns([
                TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenis_kegiatan')
                    ->badge(),

                TextColumn::make('tanggal_mulai')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('tanggal_selesai')
                    ->label('Selesai')
                    ->date('d M Y'),

                TextColumn::make('semester')
                    ->badge(),
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
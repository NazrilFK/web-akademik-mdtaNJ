<?php

namespace App\Filament\Widgets;

use App\Models\Pengumuman;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestAnnouncements extends TableWidget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 1;
    protected static ?string $heading = 'Pengumuman Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Pengumuman::query()->latest()
            )
            ->columns([
                TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('target')
                    ->badge(),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('tanggal_publish')
                    ->date('d M Y'),
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
<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('role')
                    ->badge()
                    ->colors([
                        'success' => 'admin',
                        'warning' => 'guru',
                        'info' => 'kepala_madrasah',
                    ]),

                TextColumn::make('no_hp')
                    ->label('No HP'),

                IconColumn::make('status')
                    ->boolean(),

                TextColumn::make('last_login')
                    ->label('Login Terakhir')
                    ->since()
                    ->placeholder('-')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'guru' => 'Guru',
                        'siswa' => 'Siswa',
                    ]),

                SelectFilter::make('nama_kelas')
                    ->label('Kelas')
                    ->options([
                        'Kelas 1' => 'Kelas 1',
                        'Kelas 2' => 'Kelas 2',
                        'Kelas 3' => 'Kelas 3',
                        'Kelas 4' => 'Kelas 4',
                    ]),
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

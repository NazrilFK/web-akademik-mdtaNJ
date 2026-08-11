<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),

                TextInput::make('email')
                    ->email()
                    ->required(),

                TextInput::make('no_hp')
                    ->label('No HP'),

                Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'guru' => 'Guru',
                        'kepala_madrasah' => 'Kepala Madrasah',
                        'siswa' => 'Siswa', // <-- Ditambahkan & menggunakan huruf kecil sesuai keys lainnya
                    ])
                    ->required()
                    ->reactive(), // <-- Ditambahkan agar perubahan langsung dideteksi real-time

                // Input Kelas otomatis muncul HANYA jika Role yang dipilih adalah 'siswa'
                Select::make('nama_kelas')
                    ->label('Kelas (Khusus Siswa)')
                    ->placeholder('Pilih Kelas')
                    ->options([
                        'Kelas 1' => 'Kelas 1',
                        'Kelas 2' => 'Kelas 2',
                        'Kelas 3' => 'Kelas 3',
                        'Kelas 4' => 'Kelas 4',
                    ])
                    ->visible(fn ($get) => $get('role') === 'siswa')
                    ->required(fn ($get) => $get('role') === 'siswa'),

                Toggle::make('status')
                    ->label('Aktif')
                    ->default(true),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->helperText('Kosongkan jika tidak ingin mengubah password')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->minLength(8)
                    ->maxLength(255),
            ]);
    }
}
<?php

namespace App\Filament\Resources\KalenderAkademiks\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Grid; // BERHASIL DIPERBAIKI: Menggunakan rumpun Schemas secara akurat
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class KalenderAkademikForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([

                        TextInput::make('judul')
                            ->label('Judul Kegiatan')
                            ->required()
                            ->maxLength(255),

                        Select::make('jenis_kegiatan')
                            ->label('Jenis Kegiatan')
                            ->options([
                                'Libur Sekolah' => 'Libur Sekolah',
                                'Ujian' => 'Ujian',
                                'Kegiatan Madrasah' => 'Kegiatan Madrasah',
                                'Rapat Guru' => 'Rapat Guru',
                                'Pembagian Rapor' => 'Pembagian Rapor',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->searchable()
                            ->required()
                            ->live() // Membuat form merespon secara real-time saat dipilih
                            ->afterStateUpdated(function ($state, $set) {
                                // Otomatis mengisi warna ke field 'warna' sesuai jenis kegiatan
                                $warnaOtomatis = match ($state) {
                                    'Libur Sekolah' => '#ef4444',     // Merah
                                    'Ujian' => '#a855f7',             // Ungu
                                    'Kegiatan Madrasah' => '#3b82f6', // Biru
                                    'Rapat Guru' => '#f97316',        // Orange
                                    'Pembagian Rapor' => '#10b981',   // Hijau
                                    default => '#6b7280',             // Abu-abu
                                };
                                
                                $set('warna', $warnaOtomatis);
                            }),

                        DatePicker::make('tanggal_mulai')
                            ->label('Tanggal Mulai')
                            ->required(),

                        DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai')
                            ->minDate(fn ($get) => $get('tanggal_mulai')),

                        Select::make('tahun_akademik')
                            ->options([
                                '2025/2026' => '2025/2026',
                                '2026/2027' => '2026/2027',
                                '2027/2028' => '2027/2028',
                            ])
                            ->required(),

                        Select::make('semester')
                            ->options([
                                'Ganjil' => 'Ganjil',
                                'Genap' => 'Genap',
                            ])
                            ->required(),

                        ColorPicker::make('warna')
                            ->label('Warna Event')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->placeholder('Otomatis mengikuti jenis kegiatan'),
                    ]),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->placeholder('Masukkan deskripsi kegiatan akademik...')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
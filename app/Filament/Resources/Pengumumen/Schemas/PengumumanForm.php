<?php

namespace App\Filament\Resources\Pengumumen\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PengumumanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('judul')
                    ->required()
                    ->maxLength(255),

                Textarea::make('isi')
                    ->rows(8)
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('lampiran')
                ->disk('public')
                ->directory('pengumuman')
                ->visibility('public')
                ->preserveFilenames(),

                Select::make('target')
                    ->options([
                        'Semua' => 'Semua Pengguna',
                        'Guru' => 'Guru',
                        'Kelas Tertentu' => 'Kelas Tertentu',
                    ])
                    ->live()
                    ->required(),

                Select::make('kelas_id')
                    ->relationship('kelas', 'nama_kelas')
                    ->visible(fn ($get) => $get('target') === 'Kelas Tertentu'),

                Select::make('status')
                    ->options([
                        'Draft' => 'Draft',
                        'Published' => 'Published',
                        'Scheduled' => 'Scheduled',
                    ])
                    ->required(),

                DateTimePicker::make('tanggal_publish')
                    ->label('Jadwal Publish'),

            ]);
    }
}

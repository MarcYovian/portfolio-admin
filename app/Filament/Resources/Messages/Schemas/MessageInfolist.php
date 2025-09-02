<?php

namespace App\Filament\Resources\Messages\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengirim')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')->label('Nama'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('subject')->label('Subjek')->columnSpanFull(),
                        TextEntry::make('created_at')->label('Waktu Diterima')->dateTime(),
                    ]),
                Section::make('Isi Pesan')
                    ->schema([
                        TextEntry::make('message')
                            ->label('')
                            ->markdown(), // Agar format teks lebih rapi
                    ])
            ]);
    }
}

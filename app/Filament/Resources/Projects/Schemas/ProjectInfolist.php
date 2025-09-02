<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Layout utama dengan 3 kolom

                // Panel Kiri (Konten Utama), memakan 2 dari 3 kolom
                Group::make()
                    ->schema([
                        Section::make('Project Details')
                            ->schema([
                                // Judul dibuat lebih besar untuk hierarki visual
                                TextEntry::make('title')
                                    ->size('xl')
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold),

                                // Menampilkan deskripsi dengan format Markdown
                                TextEntry::make('description')
                                    ->markdown()
                                    ->columnSpanFull(),

                                TextEntry::make('skills.name')
                                    ->label('Tech Stack')
                                    ->badge(),
                            ])->columns(1),
                    ])
                    ->columnSpan(2),

                // Panel Kanan (Sidebar), memakan 1 dari 3 kolom
                Group::make()
                    ->schema([
                        Section::make('Metadata')
                            ->schema([
                                ImageEntry::make('image_url')
                                    ->label('Image')
                                    ->hiddenLabel()
                                    ->height(180)
                                    ->width('100%'),

                                // Menampilkan nama kategori, bukan ID-nya
                                TextEntry::make('category.name')
                                    ->label('Category')
                                    ->badge(),
                            ]),
                        Section::make('Links')
                            ->schema([
                                // URL dibuat bisa diklik, ada ikon, dan bisa di-copy
                                TextEntry::make('demo_url')
                                    ->label('Demo URL')
                                    ->icon('heroicon-o-globe-alt')
                                    ->url(fn(?string $state): ?string => $state ? "https://{$state}" : null, true)
                                    ->copyable()
                                    ->copyableState(fn(?string $state): ?string => $state),

                                TextEntry::make('github_url')
                                    ->label('GitHub URL')
                                    ->icon('heroicon-o-code-bracket')
                                    ->url(fn(?string $state): string => $state, true)
                                    ->copyable()
                                    ->copyableState(fn(?string $state): string => $state),
                            ]),
                        Section::make('Timestamps')
                            ->schema([
                                TextEntry::make('created_at')->dateTime(),
                                TextEntry::make('updated_at')->since(),
                            ])->collapsible(),
                    ])
                    ->columnSpan([1]),
            ])->columns(3);
    }
}

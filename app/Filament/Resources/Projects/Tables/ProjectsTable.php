<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Models\Project;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->stacked(),
                TextColumn::make('title')
                    ->searchable()
                    ->description(fn(Project $record): string => Str::limit($record->description, 40)),
                TextColumn::make('category.name')
                    ->badge()
                    ->sortable(),
                TextColumn::make('skills.name')
                    ->badge()
                    ->label('Tech Stack')
                    ->limitList(3),
                TextColumn::make('demo_url')
                    ->label('Demo')
                    ->icon(Heroicon::OutlinedGlobeAlt)
                    ->url(fn(?string $state): ?string => $state, true) // Buka di tab baru
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan defaultnya
                TextColumn::make('github_url')
                    ->label('GitHub')
                    ->icon(Heroicon::OutlinedCodeBracket)
                    ->url(fn(?string $state): ?string => $state, true) // Buka di tab baru
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan defaultnya
                TextColumn::make('created_at')
                    ->dateTime('d M Y') // Format tanggal lebih ringkas
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Filter by Category')
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

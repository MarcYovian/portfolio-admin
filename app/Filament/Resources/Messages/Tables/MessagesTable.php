<?php

namespace App\Filament\Resources\Messages\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_read')
                    ->label('Status')
                    ->boolean(),
                TextColumn::make('name')
                    ->searchable()
                    ->weight(fn($record) => $record->is_read ? 'normal' : 'bold'),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable()
                    ->weight(fn($record) => $record->is_read ? 'normal' : 'bold'),
                TextColumn::make('subject')
                    ->searchable()
                    ->limit(50)
                    ->weight(fn($record) => $record->is_read ? 'normal' : 'bold'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('Read Status')
                    ->placeholder('All Messages')
                    ->trueLabel('Read Messages')
                    ->falseLabel('Unread Messages')
                    ->queries(
                        true: fn($query) => $query->where('is_read', true),
                        false: fn($query) => $query->where('is_read', false),
                    )
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('MarkAsRead')
                        ->label('Mark as Read')
                        ->icon('heroicon-s-check')
                        ->action(fn($records) => $records->each->update(['is_read' => true])),
                ]),
            ]);
    }
}

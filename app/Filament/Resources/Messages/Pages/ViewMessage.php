<?php

namespace App\Filament\Resources\Messages\Pages;

use App\Filament\Resources\Messages\MessageResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMessage extends ViewRecord
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reply')
                ->label('Reply')
                ->url('mailto:' . $this->record->email)
                ->icon('heroicon-o-inbox')
                ->color('success')
                ->openUrlInNewTab(),
            // EditAction::make(),
        ];
    }
}

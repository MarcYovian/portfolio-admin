<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Project Details')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        Textarea::make('description')
                            ->required()
                            ->rows(5), // Memberi tinggi yang lebih pas
                        Select::make('skills')
                            ->relationship('skills', 'name')
                            ->label('Tech Stack / Skills Used')
                            ->multiple()
                            ->searchable()
                            ->preload(),
                    ])->columnSpan(2),
                Group::make([
                    Section::make('Meta Data')
                        ->schema([
                            FileUpload::make('image_url')
                                ->label('Project Image')
                                ->image()
                                ->directory('projects')
                                ->imageEditor()
                                ->required(),
                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->label('Category')
                                ->required()
                                ->searchable()
                                ->preload(),
                        ]),
                    Section::make('Links')
                        ->schema([
                            TextInput::make('demo_url')
                                ->label('Demo URL')
                                ->url()
                                ->prefixIcon(Heroicon::OutlinedGlobeAlt),
                            TextInput::make('github_url')
                                ->label('GitHub URL')
                                ->url()
                                ->prefixIcon(Heroicon::OutlinedCodeBracket),
                        ]),
                ])->columnSpan(1),

            ])->columns(3);
    }
}

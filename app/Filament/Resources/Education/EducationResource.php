<?php

namespace App\Filament\Resources\Education;

use App\Filament\Resources\Education\Pages\ManageEducation;
use App\Models\Education;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class EducationResource extends Resource
{
    protected static ?string $model = Education::class;

    protected static string | UnitEnum | null $navigationGroup = 'About Me';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Education';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Academic Information')
                            ->schema([
                                TextInput::make('degree')
                                    ->label('Degree / Field of Study')
                                    ->required(),
                                TextInput::make('institution')
                                    ->label('Institution / University')
                                    ->required(),
                                RichEditor::make('description')
                                    ->label('Activities and Description')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(2),

                // Sidebar
                Group::make()
                    ->schema([
                        Section::make('Duration')
                            ->schema([
                                DatePicker::make('start_date')
                                    ->required(),
                                Checkbox::make('is_current')
                                    ->label('I am currently studying here')
                                    ->live()
                                    ->afterStateUpdated(fn($state, callable $set) => $state ? $set('end_date', null) : null),
                                DatePicker::make('end_date')
                                    ->hidden(fn(callable $get) => $get('is_current')),
                            ]),
                        Section::make('Grades')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('gpa')
                                        ->label('GPA')
                                        ->numeric()
                                        ->step(0.01),
                                    TextInput::make('max_gpa')
                                        ->label('Max GPA')
                                        ->numeric()
                                        ->step(0.01)
                                        ->default(4.0),
                                ]),
                            ]),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextEntry::make('degree')
                                    ->size(TextSize::Large)
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                                // Menggabungkan institusi dan rentang waktu
                                TextEntry::make('institution')
                                    ->label('')
                                    ->formatStateUsing(function (Education $record) {
                                        $startDate = $record->start_date->format('M Y');
                                        $endDate = $record->end_date ? $record->end_date->format('M Y') : 'Present';
                                        return "{$record->institution} · {$startDate} - {$endDate}";
                                    }),
                                TextEntry::make('description')
                                    ->html()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(2),

                // Sidebar
                Group::make()
                    ->schema([
                        Section::make('Details')
                            ->schema([
                                // Menampilkan GPA dengan format kustom
                                TextEntry::make('gpa')
                                    ->icon('heroicon-o-academic-cap')
                                    ->formatStateUsing(function (Education $record): ?string {
                                        if ($record->gpa && $record->max_gpa) {
                                            return "{$record->gpa} / {$record->max_gpa}";
                                        }
                                        return $record->gpa;
                                    }),
                            ]),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('degree')
            ->columns([
                // Menggabungkan Degree dan Institution
                TextColumn::make('degree')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Education $record): string => $record->institution),

                // Kolom durasi kustom
                TextColumn::make('duration')
                    ->state(function (Education $record): string {
                        $startDate = $record->start_date->format('M Y');
                        $endDate = $record->end_date ? $record->end_date->format('M Y') : 'Present';
                        return "{$startDate} - {$endDate}";
                    }),

                // Kolom GPA kustom
                TextColumn::make('gpa')
                    ->label('GPA')
                    ->state(function (Education $record): ?string {
                        if ($record->gpa && $record->max_gpa) {
                            return "{$record->gpa} / {$record->max_gpa}";
                        }
                        return $record->gpa;
                    })
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageEducation::route('/'),
        ];
    }
}

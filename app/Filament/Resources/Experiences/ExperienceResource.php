<?php

namespace App\Filament\Resources\Experiences;

use App\Filament\Resources\Experiences\Pages\ManageExperiences;
use App\Models\Experience;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static string | UnitEnum | null $navigationGroup = 'About Me';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Experience';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Role Details')
                            ->schema([
                                TextInput::make('role')
                                    ->required(),
                                TextInput::make('company')
                                    ->required(),
                                RichEditor::make('description')
                                    ->columnSpanFull()
                                    ->required(),
                                Select::make('skills')
                                    ->relationship('skills', 'name')
                                    ->label('Tech Stack / Skills Used')
                                    ->multiple()
                                    ->searchable()
                                    ->preload(),
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
                                // Checkbox untuk status pekerjaan saat ini
                                Checkbox::make('is_current')
                                    ->label('I currently work here')
                                    ->live() // Menggunakan live() untuk interaktivitas
                                    ->afterStateUpdated(fn($state, callable $set) => $state ? $set('end_date', null) : null),
                                DatePicker::make('end_date')
                                    ->hidden(fn(callable $get) => $get('is_current')), // Sembunyikan jika 'is_current' dicentang
                            ]),
                        Section::make('Key Achievements')
                            ->schema([
                                Repeater::make('achievements')
                                    ->schema([
                                        TextInput::make('achievement_text')
                                            ->required()
                                            ->label('Achievement'),
                                    ])
                                    ->addActionLabel('Add Achievement')
                                    ->reorderableWithButtons(),
                            ]),
                    ])
                    ->columnSpan(1),
            ])->columns(3);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextEntry::make('role')
                                    ->size(TextSize::Large)
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold),
                                // Menggabungkan perusahaan dan rentang waktu
                                TextEntry::make('company')
                                    ->label('')
                                    ->formatStateUsing(function (Experience $record) {
                                        $startDate = $record->start_date->format('M Y');
                                        $endDate = $record->end_date ? $record->end_date->format('M Y') : 'Present';
                                        return "{$record->company} · {$startDate} - {$endDate}";
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
                        Section::make('Key Achievements')
                            ->schema([
                                RepeatableEntry::make('achievements')
                                    ->hiddenLabel()
                                    ->schema([
                                        TextEntry::make('achievement_text')
                                            ->hiddenLabel()
                                            ->icon('heroicon-o-check-circle'),
                                    ]),
                            ]),
                    ])
                    ->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('role')
            ->columns([
                // Menggabungkan Role dan Company
                TextColumn::make('role')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Experience $record): string => $record->company),

                // Kolom durasi kustom
                TextColumn::make('duration')
                    ->state(function (Experience $record): string {
                        $startDate = $record->start_date->format('M Y');
                        $endDate = $record->end_date ? $record->end_date->format('M Y') : 'Present';
                        return "{$startDate} - {$endDate}";
                    }),

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
            'index' => ManageExperiences::route('/'),
        ];
    }
}

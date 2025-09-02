<?php

namespace App\Filament\Resources\Achievements;

use App\Filament\Resources\Achievements\Pages\ManageAchievements;
use App\Models\Achievement;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;

    protected static string | UnitEnum | null $navigationGroup = 'Main Content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Achievement';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Achievement Details')
                            ->schema([
                                TextInput::make('title')
                                    ->required(),
                                TextInput::make('issuer')
                                    ->label('Issuing Organization')
                                    ->required(),
                                Textarea::make('description')
                                    ->rows(5)
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(2),

                // Panel kanan/sidebar (memakan 1/3 space)
                Group::make()
                    ->schema([
                        Section::make('Certificate / Proof')
                            ->schema([
                                FileUpload::make('image_url')
                                    ->label('Certificate Image')
                                    ->image()
                                    ->directory('achievements')
                                    ->imageEditor()
                                    ->required(),
                                DatePicker::make('date') // Gunakan DatePicker
                                    ->required(),
                                TextInput::make('credential_url') // Ganti Textarea dengan TextInput
                                    ->label('Credential URL')
                                    ->url()
                                    ->prefixIcon('heroicon-o-link'),
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
                                // Menggabungkan judul dan deskripsi
                                TextEntry::make('title')
                                    ->size(TextSize::Medium)
                                    ->weight(FontWeight::Bold),
                                TextEntry::make('description')
                                    ->markdown()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(2),

                // Sidebar
                Group::make()
                    ->schema([
                        Section::make('Details')
                            ->schema([
                                ImageEntry::make('image_url')
                                    ->hiddenLabel()
                                    ->imageWidth(200)
                                    ->imageHeight(120),
                                // Menampilkan issuer dengan ikon
                                TextEntry::make('issuer')
                                    ->icon('heroicon-o-building-office-2'),
                                // Menampilkan tanggal dengan format yang lebih baik
                                TextEntry::make('date')
                                    ->date('d F Y') // Format: 02 September 2025
                                    ->icon('heroicon-o-calendar-days'),
                                // Menampilkan URL kredensial yang bisa diklik
                                TextEntry::make('credential_url')
                                    ->label('Verify Credential')
                                    ->icon('heroicon-o-link')
                                    ->url(fn(?string $state): ?string => $state, true)
                                    ->copyable(),
                            ]),
                    ])
                    ->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Achievement')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('issuer')
                    ->searchable(),
                TextColumn::make('date')
                    ->searchable(),
                ImageColumn::make('image_url'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
            'index' => ManageAchievements::route('/'),
        ];
    }
}

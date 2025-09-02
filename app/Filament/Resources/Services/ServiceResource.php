<?php

namespace App\Filament\Resources\Services;

use App\Filament\Resources\Services\Pages\ManageServices;
use App\Helpers\IconRenderer;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use UnitEnum;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string | UnitEnum | null $navigationGroup = 'Main Content';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Services';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Service Details')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),

                                Textarea::make('description')
                                    ->required()
                                    ->rows(6),

                                TextInput::make('icon')
                                    ->label('Icon Class or SVG')
                                    ->placeholder('heroicon-o-bolt atau <svg ...>...</svg>')
                                    ->helperText(new HtmlString('
                                        <div class="space-y-1 text-sm text-gray-500">
                                            <p><strong>Cara input icon:</strong></p>
                                            <ul style="list-style-type: disc; list-style-position: inside; margin-left: 1rem;">
                                                <li><span style="font-weight: 500;">Heroicon class name:</span> <code>heroicon-o-arrow-down-right</code></li>
                                                <li><span style="font-weight: 500;">Tanpa prefix:</span> <code>arrow-down-right</code> (otomatis jadi <code>heroicon-o-arrow-down-right</code>)</li>
                                                <li><span style="font-weight: 500;">SVG langsung:</span> paste kode <code>&lt;svg&gt;...&lt;/svg&gt;</code></li>
                                            </ul>
                                            <p>Lihat daftar lengkap Heroicons di
                                                <a href="https://heroicons.com" target="_blank" style="text-decoration: underline; color: #3b82f6">heroicons.com</a>
                                            </p>
                                        </div>
                                    '))
                                    ->reactive()
                                    ->columnSpanFull(),

                                ViewField::make('icon_preview')
                                    ->view('forms.fields.icon-preview')
                                    ->label('Preview')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(2),

                // Panel kanan/sidebar (memakan 1/3 space)
                Group::make()
                    ->schema([
                        Section::make('Features')
                            ->description('Add the key features of this service.')
                            ->schema([
                                // Repeater untuk mengelola array 'features'
                                Repeater::make('features')
                                    ->schema([
                                        TextInput::make('feature_name')
                                            ->required()
                                            ->label('Feature'),
                                    ])
                                    ->addActionLabel('Add Feature')
                                    ->reorderableWithButtons()
                                    ->collapsible()
                                    ->itemLabel(fn(array $state): ?string => $state['feature_name'] ?? null),
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
                        Section::make() // Section tanpa judul untuk konten utama
                            ->schema([
                                // Menampilkan judul dengan ikon dinamis
                                TextEntry::make('title')
                                    ->label('Service Name')
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                                    ->formatStateUsing(fn(Service $record) => IconRenderer::render($record->icon, $record->title))
                                    ->html(),

                                // Menampilkan deskripsi
                                TextEntry::make('description')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(2),

                // Panel kanan/sidebar (memakan 1/3 space)
                Group::make()
                    ->schema([
                        Section::make('Key Features')
                            ->schema([
                                // Menampilkan array 'features' sebagai daftar badge
                                RepeatableEntry::make('features')
                                    ->schema([
                                        TextEntry::make('feature_name')
                                            ->hiddenLabel(),
                                    ])
                            ]),
                        Section::make('Timestamps')
                            ->schema([
                                TextEntry::make('created_at')->dateTime(),
                                TextEntry::make('updated_at')->since(),
                            ])->collapsible(),
                    ])
                    ->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('icon')
                    ->label('Icon')
                    ->formatStateUsing(fn(?string $state) => IconRenderer::render($state))
                    ->html(),
                TextColumn::make('title')
                    ->label('Service')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Service $record): string => Str::limit($record->description, 50)),
                TextColumn::make('features')
                    ->label('Key Features')
                    ->formatStateUsing(function ($state) {
                        if (blank($state)) {
                            return null;
                        }

                        return $state['feature_name'];
                    })
                    ->badge()
                    ->limitList(3)
                    ->expandableLimitedList(),
                TextColumn::make('updated_at')
                    ->since()
                    ->label('Last Updated')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Created')
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
            'index' => ManageServices::route('/'),
        ];
    }
}

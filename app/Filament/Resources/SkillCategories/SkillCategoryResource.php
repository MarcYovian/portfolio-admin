<?php

namespace App\Filament\Resources\SkillCategories;

use App\Filament\Resources\SkillCategories\Pages\ManageSkillCategories;
use App\Models\SkillCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use UnitEnum;

class SkillCategoryResource extends Resource
{
    protected static ?string $model = SkillCategory::class;

    protected static string | UnitEnum | null $navigationGroup = 'Master Data';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Skill Category';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),

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
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Skill Category')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
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
            'index' => ManageSkillCategories::route('/'),
        ];
    }
}

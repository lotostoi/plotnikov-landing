<?php

namespace App\Filament\Resources\ContentSections;

use App\Models\LandingBlock;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

abstract class BaseSectionBlocksResource extends Resource
{
    protected static ?string $model = LandingBlock::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static UnitEnum|string|null $navigationGroup = 'Редактирование контента';
    protected static ?string $modelLabel = 'Блок';
    protected static ?string $pluralModelLabel = 'Блоки';

    abstract protected static function sectionCode(): string;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Hidden::make('section_code')
                ->default(static::sectionCode())
                ->required(),

            TextInput::make('block_key')
                ->label('Ключ блока (уникальный в секции)')
                ->required()
                ->maxLength(255)
                ->helperText('Например: heading, cta_primary, review_1, faq_2'),

            TextInput::make('block_type')
                ->label('Тип блока')
                ->required()
                ->maxLength(100)
                ->helperText('Пример: text, card, faq, review, article, stat, chip'),

            TextInput::make('label')
                ->label('Label / Иконка / Категория')
                ->maxLength(255),

            TextInput::make('badge')
                ->label('Бейдж')
                ->maxLength(255),

            TextInput::make('title')
                ->label('Заголовок')
                ->maxLength(255),

            TextInput::make('subtitle')
                ->label('Подзаголовок')
                ->maxLength(255),

            Textarea::make('body')
                ->label('Текст')
                ->rows(4),

            TextInput::make('button_text')
                ->label('Текст кнопки')
                ->maxLength(255),

            TextInput::make('button_url')
                ->label('URL кнопки / ссылки')
                ->maxLength(500),

            Textarea::make('meta')
                ->label('Meta JSON (доп. поля)')
                ->rows(4)
                ->formatStateUsing(fn ($state): string => empty($state) ? '' : json_encode($state, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT))
                ->dehydrateStateUsing(function ($state): ?array {
                    if (blank($state)) {
                        return null;
                    }

                    $decoded = json_decode((string) $state, true);

                    return is_array($decoded) ? $decoded : null;
                })
                ->helperText('Например: {"price":3500,"currency":"RUB"}'),

            TextInput::make('sort_order')
                ->label('Порядок')
                ->required()
                ->numeric()
                ->default(100),

            Toggle::make('is_visible')
                ->label('Показывать блок')
                ->default(true)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
                TextColumn::make('block_key')
                    ->label('Ключ')
                    ->searchable(),
                TextColumn::make('block_type')
                    ->label('Тип')
                    ->badge(),
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->limit(40)
                    ->searchable(),
                IconColumn::make('is_visible')
                    ->label('Видим')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make(),
                DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('section_code', static::sectionCode());
    }
}


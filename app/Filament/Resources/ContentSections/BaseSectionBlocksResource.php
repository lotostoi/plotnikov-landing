<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Models\LandingBlock;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width('60px'),
                TextColumn::make('block_key')
                    ->label('Ключ')
                    ->searchable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('title')
                    ->label('Заголовок / Имя')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('body')
                    ->label('Текст')
                    ->limit(60)
                    ->wrap(),
                IconColumn::make('is_visible')
                    ->label('Показывать')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Изменён')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()->label('Редактировать'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('section_code', static::sectionCode());
    }
}

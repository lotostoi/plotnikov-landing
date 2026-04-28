<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\ServicesBlocksResource\Pages\CreateServicesBlock;
use App\Filament\Resources\ContentSections\ServicesBlocksResource\Pages\EditServicesBlock;
use App\Filament\Resources\ContentSections\ServicesBlocksResource\Pages\ListServicesBlocks;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServicesBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Услуги';
    protected static ?int $navigationSort = 13;

    protected static function sectionCode(): string
    {
        return 'services';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Тип и ключ')
                ->columns(3)
                ->schema([
                    TextInput::make('block_key')
                        ->label('Ключ')
                        ->required()
                        ->maxLength(255)
                        ->helperText('heading, issue_1…, format_1…, price_regular, price_promo'),
                    TextInput::make('block_type')
                        ->label('Тип')
                        ->required()
                        ->maxLength(100)
                        ->helperText('text, card, format, price'),
                    TextInput::make('sort_order')
                        ->label('Порядок')
                        ->numeric()
                        ->default(100)
                        ->required(),
                ]),

            Section::make('Содержимое карточки / блока')
                ->columns(2)
                ->schema([
                    TextInput::make('badge')
                        ->label('Бейдж / Акция')
                        ->maxLength(255),
                    TextInput::make('label')
                        ->label('Иконка (Lucide)')
                        ->maxLength(255)
                        ->helperText('heart-crack, brain, shield, flame, moon, users, video, map-pin, clock'),
                    TextInput::make('title')
                        ->label('Заголовок карточки')
                        ->maxLength(255),
                    TextInput::make('subtitle')
                        ->label('Подзаголовок / Формат')
                        ->maxLength(255)
                        ->helperText('Для price — описание формата (1 встреча — 55 минут)'),
                    Textarea::make('body')
                        ->label('Описание / Примечание')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Section::make('Цена (только для блоков price_*)')
                ->columns(2)
                ->schema([
                    TextInput::make('meta.price')
                        ->label('Цена (руб.)')
                        ->numeric()
                        ->placeholder('3500'),
                    TextInput::make('meta.currency')
                        ->label('Валюта')
                        ->default('RUB')
                        ->maxLength(10),
                    TextInput::make('meta.left_places')
                        ->label('Осталось мест')
                        ->numeric()
                        ->placeholder('2'),
                ]),

            Toggle::make('is_visible')
                ->label('Показывать блок')
                ->default(true),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListServicesBlocks::route('/'),
            'create' => CreateServicesBlock::route('/create'),
            'edit'   => EditServicesBlock::route('/{record}/edit'),
        ];
    }
}

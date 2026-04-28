<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\FooterBlocksResource\Pages\CreateFooterBlock;
use App\Filament\Resources\ContentSections\FooterBlocksResource\Pages\EditFooterBlock;
use App\Filament\Resources\ContentSections\FooterBlocksResource\Pages\ListFooterBlocks;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FooterBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Футер';
    protected static ?int $navigationSort = 19;

    protected static function sectionCode(): string
    {
        return 'footer';
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
                        ->helperText('brand, copyright'),
                    TextInput::make('block_type')
                        ->label('Тип')
                        ->required()
                        ->maxLength(100)
                        ->helperText('brand, text'),
                    TextInput::make('sort_order')
                        ->label('Порядок')
                        ->numeric()
                        ->default(100)
                        ->required(),
                ]),

            Section::make('Содержимое')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Имя / Название')
                        ->placeholder('Александр')
                        ->maxLength(255),
                    TextInput::make('subtitle')
                        ->label('Подпись / Профессия')
                        ->placeholder('психолог')
                        ->maxLength(255),
                    Textarea::make('body')
                        ->label('Описание / Копирайт')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Toggle::make('is_visible')
                ->label('Показывать блок')
                ->default(true),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListFooterBlocks::route('/'),
            'create' => CreateFooterBlock::route('/create'),
            'edit'   => EditFooterBlock::route('/{record}/edit'),
        ];
    }
}

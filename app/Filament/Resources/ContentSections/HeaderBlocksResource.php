<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\HeaderBlocksResource\Pages\CreateHeaderBlock;
use App\Filament\Resources\ContentSections\HeaderBlocksResource\Pages\EditHeaderBlock;
use App\Filament\Resources\ContentSections\HeaderBlocksResource\Pages\ListHeaderBlocks;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HeaderBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Шапка';
    protected static ?int $navigationSort = 10;

    protected static function sectionCode(): string
    {
        return 'header';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Содержимое блока')
                ->description('Ключ блока определяет его роль: brand — название/имя, cta — кнопка, nav_* — пункт меню.')
                ->columns(2)
                ->schema([
                    TextInput::make('block_key')
                        ->label('Ключ блока')
                        ->required()
                        ->maxLength(255)
                        ->helperText('brand, cta, nav_about, nav_services…'),
                    TextInput::make('block_type')
                        ->label('Тип блока')
                        ->required()
                        ->maxLength(100)
                        ->helperText('brand, cta, nav_item'),
                    TextInput::make('title')
                        ->label('Имя / Текст (name/title)')
                        ->maxLength(255)
                        ->helperText('Для brand — имя; для nav_item — метка меню; для cta — текст кнопки'),
                    TextInput::make('subtitle')
                        ->label('Профессия / Подпись (subtitle)')
                        ->maxLength(255)
                        ->helperText('Для brand — подпись под именем'),
                    TextInput::make('label')
                        ->label('Label')
                        ->maxLength(255),
                    TextInput::make('button_text')
                        ->label('Текст кнопки')
                        ->maxLength(255),
                    TextInput::make('button_url')
                        ->label('Ссылка (URL или #anchor)')
                        ->maxLength(500),
                    TextInput::make('sort_order')
                        ->label('Порядок')
                        ->numeric()
                        ->default(100)
                        ->required(),
                    Toggle::make('is_visible')
                        ->label('Показывать')
                        ->default(true)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListHeaderBlocks::route('/'),
            'create' => CreateHeaderBlock::route('/create'),
            'edit'   => EditHeaderBlock::route('/{record}/edit'),
        ];
    }
}

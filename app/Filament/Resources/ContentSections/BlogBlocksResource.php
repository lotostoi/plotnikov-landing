<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\BlogBlocksResource\Pages\CreateBlogBlock;
use App\Filament\Resources\ContentSections\BlogBlocksResource\Pages\EditBlogBlock;
use App\Filament\Resources\ContentSections\BlogBlocksResource\Pages\ListBlogBlocks;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Блог';
    protected static ?int $navigationSort = 16;

    protected static function sectionCode(): string
    {
        return 'blog';
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
                        ->helperText('heading, cta_all, article_1, article_2, article_3…'),
                    TextInput::make('block_type')
                        ->label('Тип')
                        ->required()
                        ->maxLength(100)
                        ->helperText('text, cta, article'),
                    TextInput::make('sort_order')
                        ->label('Порядок')
                        ->numeric()
                        ->default(100)
                        ->required(),
                ]),

            Section::make('Содержимое статьи / блока')
                ->columns(2)
                ->schema([
                    TextInput::make('badge')
                        ->label('Категория')
                        ->placeholder('Терапия')
                        ->maxLength(255),
                    TextInput::make('title')
                        ->label('Заголовок статьи')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Textarea::make('body')
                        ->label('Описание / Анонс')
                        ->rows(4)
                        ->columnSpanFull(),
                    TextInput::make('button_text')
                        ->label('Текст кнопки (для cta)')
                        ->maxLength(255),
                    TextInput::make('button_url')
                        ->label('Ссылка кнопки (для cta)')
                        ->maxLength(500),
                ]),

            Section::make('Мета статьи')
                ->description('Только для блоков типа article.')
                ->columns(2)
                ->schema([
                    TextInput::make('meta.date')
                        ->label('Дата публикации')
                        ->placeholder('15 января 2024'),
                    TextInput::make('meta.readTime')
                        ->label('Время чтения')
                        ->placeholder('5 мин'),
                ]),

            Toggle::make('is_visible')
                ->label('Показывать блок')
                ->default(true),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListBlogBlocks::route('/'),
            'create' => CreateBlogBlock::route('/create'),
            'edit'   => EditBlogBlock::route('/{record}/edit'),
        ];
    }
}

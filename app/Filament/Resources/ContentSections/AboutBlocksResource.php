<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\AboutBlocksResource\Pages\CreateAboutBlock;
use App\Filament\Resources\ContentSections\AboutBlocksResource\Pages\EditAboutBlock;
use App\Filament\Resources\ContentSections\AboutBlocksResource\Pages\ListAboutBlocks;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Обо мне';
    protected static ?int $navigationSort = 12;

    protected static function sectionCode(): string
    {
        return 'about';
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
                        ->helperText('heading, paragraph_1, paragraph_2, value_1…'),
                    TextInput::make('block_type')
                        ->label('Тип')
                        ->required()
                        ->maxLength(100)
                        ->helperText('text, paragraph, card'),
                    TextInput::make('sort_order')
                        ->label('Порядок')
                        ->numeric()
                        ->default(100)
                        ->required(),
                ]),

            Section::make('Содержимое')
                ->columns(2)
                ->schema([
                    TextInput::make('badge')
                        ->label('Бейдж')
                        ->placeholder('Обо мне')
                        ->maxLength(255),
                    TextInput::make('label')
                        ->label('Label / Иконка')
                        ->maxLength(255)
                        ->helperText('Для value-карточек: heart, users, briefcase, sparkles'),
                    TextInput::make('title')
                        ->label('Заголовок')
                        ->maxLength(255),
                    TextInput::make('subtitle')
                        ->label('Подзаголовок')
                        ->maxLength(255),
                    Textarea::make('body')
                        ->label('Текст / Описание')
                        ->rows(5)
                        ->columnSpanFull(),
                ]),

            Section::make('Фото секции «Обо мне»')
                ->description('Только для блока heading. Загрузите фото или укажите внешний URL.')
                ->columns(2)
                ->schema([
                    FileUpload::make('meta.image_path')
                        ->label('Загрузить фото')
                        ->image()
                        ->disk('public')
                        ->directory('about')
                        ->maxSize(5120),
                    TextInput::make('meta.image_url')
                        ->label('Или внешний URL фото')
                        ->url()
                        ->maxLength(500),
                ]),

            Toggle::make('is_visible')
                ->label('Показывать блок')
                ->default(true),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAboutBlocks::route('/'),
            'create' => CreateAboutBlock::route('/create'),
            'edit'   => EditAboutBlock::route('/{record}/edit'),
        ];
    }
}

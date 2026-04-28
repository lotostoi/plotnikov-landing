<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\ContactsBlocksResource\Pages\CreateContactsBlock;
use App\Filament\Resources\ContentSections\ContactsBlocksResource\Pages\EditContactsBlock;
use App\Filament\Resources\ContentSections\ContactsBlocksResource\Pages\ListContactsBlocks;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactsBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Контакты';
    protected static ?int $navigationSort = 18;

    protected static function sectionCode(): string
    {
        return 'contacts';
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
                        ->helperText('heading, free_call, cta_telegram, cta_whatsapp, nickname, location'),
                    TextInput::make('block_type')
                        ->label('Тип')
                        ->required()
                        ->maxLength(100)
                        ->helperText('text, card, cta'),
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
                        ->maxLength(255),
                    TextInput::make('label')
                        ->label('Иконка (Lucide) / Label')
                        ->maxLength(255)
                        ->helperText('send, message-circle, map-pin, phone'),
                    TextInput::make('title')
                        ->label('Заголовок / Имя')
                        ->maxLength(255),
                    TextInput::make('subtitle')
                        ->label('Подзаголовок / Детали')
                        ->maxLength(255),
                    Textarea::make('body')
                        ->label('Описание')
                        ->rows(4)
                        ->columnSpanFull(),
                    TextInput::make('button_text')
                        ->label('Текст кнопки')
                        ->maxLength(255),
                    TextInput::make('button_url')
                        ->label('Ссылка / URL')
                        ->maxLength(500),
                ]),

            Section::make('Фото секции «Контакты»')
                ->description('Загрузите фото или укажите внешний URL.')
                ->columns(2)
                ->schema([
                    FileUpload::make('meta.image_path')
                        ->label('Загрузить фото')
                        ->image()
                        ->disk('public')
                        ->directory('contacts')
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
            'index'  => ListContactsBlocks::route('/'),
            'create' => CreateContactsBlock::route('/create'),
            'edit'   => EditContactsBlock::route('/{record}/edit'),
        ];
    }
}

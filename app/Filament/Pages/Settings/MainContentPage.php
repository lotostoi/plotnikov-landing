<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class MainContentPage extends BaseSettingsPage
{
    protected static ?string $navigationLabel = 'Основной контент';
    protected static ?string $title = 'Основной контент';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static ?int $navigationSort = 1;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Хиро-секция')
                ->columns(2)
                ->schema([
                    TextInput::make('hero_badge')
                        ->label('Бейдж (подпись над именем)')
                        ->placeholder('Гештальт-терапевт')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    TextInput::make('hero_title')
                        ->label('Главный заголовок')
                        ->placeholder('Здравствуйте, я Александр')
                        ->maxLength(255),
                    TextInput::make('h1_text')
                        ->label('H1 (если отличается от заголовка)')
                        ->maxLength(255),
                    Textarea::make('hero_description')
                        ->label('Описание')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Section::make('Контакты')
                ->columns(2)
                ->schema([
                    TextInput::make('contact_handle')
                        ->label('Никнейм / username')
                        ->placeholder('@AlexanderP_V')
                        ->maxLength(255),
                    TextInput::make('location_text')
                        ->label('Локация')
                        ->placeholder('Владивосток, Артём')
                        ->maxLength(255),
                    TextInput::make('telegram_url')
                        ->label('Ссылка Telegram')
                        ->url()
                        ->maxLength(255),
                    TextInput::make('whatsapp_url')
                        ->label('Ссылка WhatsApp')
                        ->url()
                        ->maxLength(255),
                ]),
        ];
    }
}

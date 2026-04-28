<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ContactsSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'contacts';
    protected static ?string $navigationLabel = 'Контакты';
    protected static ?string $title = 'Секция «Контакты»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPhone;
    protected static ?int $navigationSort = 9;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Заголовок секции')
                ->columns(2)
                ->schema([
                    TextInput::make('heading.badge')->label('Бейдж')->placeholder('Контакты')->maxLength(255),
                    TextInput::make('heading.title')->label('Первая строка')->placeholder('Запишитесь на')->maxLength(255),
                    TextInput::make('heading.subtitle')->label('Вторая строка')->placeholder('консультацию')->maxLength(255),
                    Textarea::make('heading.body')->label('Подзаголовок')->rows(2)->columnSpanFull(),
                    Toggle::make('heading.is_visible')->label('Показывать секцию')->default(true)->columnSpanFull(),
                ]),

            Section::make('Карточка «Бесплатный созвон»')
                ->schema([
                    TextInput::make('free_call.title')->label('Заголовок')->placeholder('Бесплатный созвон')->maxLength(255),
                    TextInput::make('free_call.subtitle')->label('Подзаголовок')->placeholder('15 минут для знакомства')->maxLength(255),
                    Textarea::make('free_call.body')->label('Описание')->rows(3),
                ]),

            Section::make('Кнопки мессенджеров')
                ->columns(2)
                ->schema([
                    TextInput::make('cta_telegram.button_text')->label('Telegram — текст')->placeholder('Telegram')->maxLength(255),
                    TextInput::make('cta_telegram.button_url')->label('Telegram — ссылка')->placeholder('https://t.me/...')->maxLength(500),
                    TextInput::make('cta_whatsapp.button_text')->label('WhatsApp — текст')->placeholder('WhatsApp')->maxLength(255),
                    TextInput::make('cta_whatsapp.button_url')->label('WhatsApp — ссылка')->placeholder('https://wa.me/...')->maxLength(500),
                ]),

            Section::make('Никнейм и локация')
                ->columns(2)
                ->schema([
                    TextInput::make('nickname.title')->label('Никнейм (ссылка)')->placeholder('@AlexanderP_V')->maxLength(255),
                    TextInput::make('location.title')->label('Локация — заголовок')->placeholder('Очный приём')->maxLength(255),
                    TextInput::make('location.subtitle')->label('Локация — адрес')->placeholder('Владивосток, Артём')->maxLength(255),
                    TextInput::make('location.label')->label('Локация — иконка (Lucide)')->placeholder('map-pin')->maxLength(100),
                ]),
        ];
    }
}

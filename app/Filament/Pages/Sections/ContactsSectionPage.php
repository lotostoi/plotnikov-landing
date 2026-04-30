<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\FileUpload;
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
            Section::make('Фотография секции')
                ->description('Портретное фото справа. Если не загружено — используется фото по умолчанию.')
                ->schema([
                    FileUpload::make('heading.button_url')
                        ->label('Фото (портрет)')
                        ->image()
                        ->disk('public')
                        ->directory('contacts')
                        ->imagePreviewHeight('200')
                        ->imageEditor()
                        ->imageEditorAspectRatios(['3:4', '2:3', null])
                        ->downloadable()
                        ->helperText('Рекомендуется портретная ориентация (3:4).'),
                ]),

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

            Section::make('Личные мессенджеры')
                ->description('Кнопка Telegram — личные сообщения (не канал). Канал задаётся отдельным блоком ниже.')
                ->columns(2)
                ->schema([
                    TextInput::make('cta_telegram.button_text')->label('Telegram — текст кнопки')->placeholder('Telegram')->maxLength(255),
                    TextInput::make('cta_telegram.button_url')->label('Telegram — ссылка (личный чат)')->placeholder('https://t.me/username')->maxLength(500),
                    TextInput::make('cta_telegram.label')->label('Telegram — иконка Lucide')->placeholder('send')->maxLength(100),
                    TextInput::make('cta_whatsapp.button_text')->label('WhatsApp — текст')->placeholder('WhatsApp')->maxLength(255),
                    TextInput::make('cta_whatsapp.button_url')->label('WhatsApp — ссылка')->placeholder('https://wa.me/7...')->maxLength(500),
                    TextInput::make('cta_whatsapp.label')->label('WhatsApp — иконка Lucide')->placeholder('message-circle')->maxLength(100),
                    TextInput::make('cta_max.button_text')->label('Max — текст')->placeholder('Max')->maxLength(255),
                    TextInput::make('cta_max.button_url')->label('Max — ссылка')->placeholder('https://max.ru/u/...')->maxLength(500),
                    TextInput::make('cta_max.label')->label('Max — иконка Lucide')->placeholder('message-square')->maxLength(100),
                ]),

            Section::make('Telegram-канал (отдельно от лички)')
                ->schema([
                    TextInput::make('telegram_channel.title')->label('Заголовок карточки')->placeholder('Читайте обо мне в Telegram')->maxLength(255),
                    TextInput::make('telegram_channel.subtitle')->label('Подзаголовок')->maxLength(255),
                    TextInput::make('telegram_channel.button_text')->label('Текст ссылки')->placeholder('Открыть канал')->maxLength(255),
                    TextInput::make('telegram_channel.button_url')->label('Ссылка на канал')->placeholder('https://t.me/...')->maxLength(500),
                    TextInput::make('telegram_channel.label')->label('Иконка Lucide')->placeholder('newspaper')->maxLength(100),
                    Toggle::make('telegram_channel.is_visible')->label('Показывать карточку канала')->default(true),
                ]),

            Section::make('Телефон, ник и локация')
                ->columns(2)
                ->schema([
                    TextInput::make('phone.title')->label('Телефон (отображение)')->placeholder('+7 924 252-17-56')->maxLength(255),
                    TextInput::make('phone.button_url')->label('Телефон — ссылка tel:')->placeholder('tel:+79242521756')->maxLength(255),
                    TextInput::make('nickname.title')->label('Ник в Telegram (под кнопкой лички)')->placeholder('@AlexanderP_V')->maxLength(255),
                    TextInput::make('nickname.label')->label('Подпись к нику')->placeholder('Ник в Telegram')->maxLength(255),
                    TextInput::make('location.title')->label('Локация — заголовок')->placeholder('Очный приём')->maxLength(255),
                    TextInput::make('location.subtitle')->label('Локация — адрес')->placeholder('Владивосток, Артём')->maxLength(255),
                    TextInput::make('location.label')->label('Локация — иконка (Lucide)')->placeholder('map-pin')->maxLength(100),
                ]),
        ];
    }
}

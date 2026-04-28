<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class SeoPage extends BaseSettingsPage
{
    protected static ?string $navigationLabel = 'SEO и мета';
    protected static ?string $title = 'SEO и мета';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlass;
    protected static ?int $navigationSort = 2;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Мета-теги')
                ->schema([
                    TextInput::make('seo_title')
                        ->label('SEO title (до 60 символов)')
                        ->maxLength(255)
                        ->helperText('Появляется в выдаче и в табе браузера. Оптимально 50–60 символов.'),
                    Textarea::make('seo_description')
                        ->label('SEO description (до 160 символов)')
                        ->rows(3)
                        ->helperText('Краткое описание для поисковиков. Оптимально 140–160 символов.'),
                    TextInput::make('seo_keywords')
                        ->label('SEO keywords (через запятую)')
                        ->maxLength(500),
                    TextInput::make('canonical_url')
                        ->label('Canonical URL')
                        ->url()
                        ->placeholder('https://plotnikov-al-psy.online'),
                    Select::make('robots')
                        ->label('Robots')
                        ->options([
                            'index,follow'    => 'index, follow (по умолчанию)',
                            'index,nofollow'  => 'index, nofollow',
                            'noindex,follow'  => 'noindex, follow',
                            'noindex,nofollow'=> 'noindex, nofollow',
                        ])
                        ->default('index,follow'),
                ]),

            Section::make('Open Graph и иконки')
                ->columns(2)
                ->schema([
                    FileUpload::make('og_image_path')
                        ->label('OG image (1200×630)')
                        ->image()
                        ->disk('public')
                        ->directory('seo')
                        ->maxSize(4096)
                        ->columnSpanFull()
                        ->helperText('Используется в og:image и twitter:image. Если пусто — берётся hero-фото.'),
                    TextInput::make('og_image_url')
                        ->label('Внешний URL OG image')
                        ->url()
                        ->maxLength(500)
                        ->columnSpanFull(),
                    FileUpload::make('favicon_path')
                        ->label('Favicon (32×32)')
                        ->image()
                        ->disk('public')
                        ->directory('seo')
                        ->acceptedFileTypes(['image/png', 'image/x-icon', 'image/svg+xml', 'image/vnd.microsoft.icon']),
                    FileUpload::make('apple_touch_icon_path')
                        ->label('Apple touch icon (180×180)')
                        ->image()
                        ->disk('public')
                        ->directory('seo')
                        ->acceptedFileTypes(['image/png']),
                ]),

            Section::make('Person (Schema.org)')
                ->columns(2)
                ->schema([
                    TextInput::make('person_name')
                        ->label('Короткое имя')
                        ->placeholder('Александр')
                        ->maxLength(255),
                    TextInput::make('person_full_name')
                        ->label('Полное имя')
                        ->placeholder('Александр П Психолог')
                        ->maxLength(255),
                    TextInput::make('person_job_title')
                        ->label('Должность')
                        ->placeholder('Психолог, гештальт-терапевт')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Textarea::make('person_bio')
                        ->label('Краткое био')
                        ->rows(3)
                        ->columnSpanFull(),
                    TextInput::make('person_image_url')
                        ->label('URL фото для Person')
                        ->url()
                        ->maxLength(500)
                        ->columnSpanFull(),
                    TextInput::make('person_phone')
                        ->label('Телефон')
                        ->tel()
                        ->maxLength(50),
                    TextInput::make('person_email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255),
                ]),

            Section::make('Адрес и часы')
                ->columns(2)
                ->schema([
                    TextInput::make('address_locality')
                        ->label('Город')
                        ->placeholder('Владивосток'),
                    TextInput::make('address_region')
                        ->label('Регион')
                        ->placeholder('Приморский край'),
                    TextInput::make('address_country')
                        ->label('Код страны (ISO)')
                        ->default('RU')
                        ->maxLength(2),
                    TextInput::make('address_postal')
                        ->label('Индекс')
                        ->maxLength(20),
                    TextInput::make('address_street')
                        ->label('Улица, дом')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    TextInput::make('geo_lat')
                        ->label('Широта')
                        ->numeric()
                        ->step('0.0000001'),
                    TextInput::make('geo_lng')
                        ->label('Долгота')
                        ->numeric()
                        ->step('0.0000001'),
                    TextInput::make('opening_hours')
                        ->label('Часы работы')
                        ->placeholder('Mo-Fr 09:00-21:00')
                        ->helperText('Формат Schema.org: Mo-Fr 09:00-21:00')
                        ->maxLength(255),
                    TextInput::make('price_range')
                        ->label('Ценовой диапазон')
                        ->default('₽₽')
                        ->placeholder('₽₽')
                        ->maxLength(10),
                ]),

            Section::make('Цены и рейтинг')
                ->columns(3)
                ->schema([
                    TextInput::make('price_regular')
                        ->label('Стандартная цена (₽)')
                        ->numeric()
                        ->placeholder('3500'),
                    TextInput::make('price_promo')
                        ->label('Промо-цена (₽)')
                        ->numeric()
                        ->placeholder('2000'),
                    TextInput::make('price_currency')
                        ->label('Валюта')
                        ->default('RUB')
                        ->maxLength(3),
                    TextInput::make('aggregate_rating_value')
                        ->label('Средний рейтинг (1–5)')
                        ->numeric()
                        ->step('0.01')
                        ->minValue(1)
                        ->maxValue(5),
                    TextInput::make('aggregate_rating_count')
                        ->label('Количество отзывов')
                        ->numeric()
                        ->minValue(0),
                ]),
        ];
    }
}

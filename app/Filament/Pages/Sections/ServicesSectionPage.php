<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ServicesSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'services';
    protected static ?string $navigationLabel = 'Услуги';
    protected static ?string $title = 'Секция «Услуги»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;
    protected static ?int $navigationSort = 4;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Заголовок секции')
                ->columns(2)
                ->schema([
                    TextInput::make('heading.badge')->label('Бейдж')->placeholder('Услуги')->maxLength(255),
                    TextInput::make('heading.title')->label('Первая строка')->placeholder('С чем я')->maxLength(255),
                    TextInput::make('heading.subtitle')->label('Вторая строка')->placeholder('работаю')->maxLength(255),
                    Textarea::make('heading.body')->label('Подзаголовок / подходы')->rows(2)->columnSpanFull(),
                    Toggle::make('heading.is_visible')->label('Показывать секцию')->default(true)->columnSpanFull(),
                ]),

            Section::make('С чем работаю — карточки проблем')
                ->description('Иконка — название из Lucide Icons. Цвет акцента: amber, rose, teal, violet, emerald, indigo.')
                ->columns(3)
                ->schema([
                    TextInput::make('issue_1.title')->label('Карточка 1 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_1.label')->label('Иконка (Lucide)')->placeholder('heart-crack')->maxLength(100),
                    TextInput::make('issue_1.badge')->label('Цвет акцента')->placeholder('rose')->maxLength(50),
                    Textarea::make('issue_1.body')->label('Описание')->rows(2)->columnSpanFull(),

                    TextInput::make('issue_2.title')->label('Карточка 2 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_2.label')->label('Иконка (Lucide)')->placeholder('zap')->maxLength(100),
                    TextInput::make('issue_2.badge')->label('Цвет акцента')->placeholder('amber')->maxLength(50),
                    Textarea::make('issue_2.body')->label('Описание')->rows(2)->columnSpanFull(),

                    TextInput::make('issue_3.title')->label('Карточка 3 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_3.label')->label('Иконка (Lucide)')->placeholder('compass')->maxLength(100),
                    TextInput::make('issue_3.badge')->label('Цвет акцента')->placeholder('teal')->maxLength(50),
                    Textarea::make('issue_3.body')->label('Описание')->rows(2)->columnSpanFull(),

                    TextInput::make('issue_4.title')->label('Карточка 4 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_4.label')->label('Иконка (Lucide)')->placeholder('mountain-snow')->maxLength(100),
                    TextInput::make('issue_4.badge')->label('Цвет акцента')->placeholder('violet')->maxLength(50),
                    Textarea::make('issue_4.body')->label('Описание')->rows(2)->columnSpanFull(),

                    TextInput::make('issue_5.title')->label('Карточка 5 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_5.label')->label('Иконка (Lucide)')->placeholder('battery-low')->maxLength(100),
                    TextInput::make('issue_5.badge')->label('Цвет акцента')->placeholder('emerald')->maxLength(50),
                    Textarea::make('issue_5.body')->label('Описание')->rows(2)->columnSpanFull(),

                    TextInput::make('issue_6.title')->label('Карточка 6 — заголовок')->maxLength(255)->columnSpanFull(),
                    TextInput::make('issue_6.label')->label('Иконка (Lucide)')->placeholder('users-round')->maxLength(100),
                    TextInput::make('issue_6.badge')->label('Цвет акцента')->placeholder('indigo')->maxLength(50),
                    Textarea::make('issue_6.body')->label('Описание')->rows(2)->columnSpanFull(),
                ]),

            Section::make('Форматы работы')
                ->columns(3)
                ->schema([
                    TextInput::make('format_1.title')->label('Формат 1')->placeholder('Онлайн')->maxLength(255),
                    TextInput::make('format_2.title')->label('Формат 2')->placeholder('Очно')->maxLength(255),
                    TextInput::make('format_3.title')->label('Формат 3')->placeholder('55 минут')->maxLength(255),
                    Textarea::make('format_1.body')->label('Описание 1')->rows(2),
                    Textarea::make('format_2.body')->label('Описание 2')->rows(2),
                    Textarea::make('format_3.body')->label('Описание 3')->rows(2),
                ]),

            Section::make('Стандартная консультация (цена)')
                ->columns(2)
                ->schema([
                    TextInput::make('price_regular.title')->label('Заголовок')->maxLength(255),
                    TextInput::make('price_regular.subtitle')->label('Подзаголовок')->maxLength(255),
                    Textarea::make('price_regular.body')->label('Описание')->rows(2)->columnSpanFull(),
                    TextInput::make('price_regular.meta.price')
                        ->label('Цена (число)')
                        ->numeric()
                        ->placeholder('3500'),
                    TextInput::make('price_regular.meta.currency')
                        ->label('Валюта')
                        ->placeholder('RUB')
                        ->maxLength(10),
                ]),

            Section::make('Акция / регулярная терапия (цена)')
                ->columns(2)
                ->schema([
                    TextInput::make('price_promo.badge')->label('Бейдж')->placeholder('Акция')->maxLength(100),
                    TextInput::make('price_promo.title')->label('Заголовок')->maxLength(255),
                    TextInput::make('price_promo.subtitle')->label('Подзаголовок')->maxLength(255),
                    Textarea::make('price_promo.body')->label('Описание')->rows(2)->columnSpanFull(),
                    TextInput::make('price_promo.meta.price')
                        ->label('Цена (число)')
                        ->numeric()
                        ->placeholder('2000'),
                    TextInput::make('price_promo.meta.currency')
                        ->label('Валюта')
                        ->placeholder('RUB')
                        ->maxLength(10),
                    TextInput::make('price_promo.meta.left_places')
                        ->label('Осталось мест')
                        ->numeric()
                        ->placeholder('2'),
                ]),
        ];
    }
}

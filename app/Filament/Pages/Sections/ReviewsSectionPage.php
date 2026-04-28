<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class ReviewsSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'reviews';
    protected static ?string $navigationLabel = 'Отзывы';
    protected static ?string $title = 'Секция «Отзывы»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;
    protected static ?int $navigationSort = 6;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Заголовок секции')
                ->columns(2)
                ->schema([
                    TextInput::make('heading.badge')->label('Бейдж')->placeholder('Отзывы')->maxLength(255),
                    TextInput::make('heading.title')->label('Первая строка')->placeholder('Что говорят')->maxLength(255),
                    TextInput::make('heading.subtitle')->label('Вторая строка')->placeholder('клиенты')->maxLength(255),
                    Textarea::make('heading.body')->label('Подзаголовок')->rows(2)->columnSpanFull(),
                    Toggle::make('heading.is_visible')->label('Показывать секцию')->default(true)->columnSpanFull(),
                ]),

            Section::make('Отзыв 1')
                ->schema([
                    TextInput::make('review_1.title')->label('Имя клиента')->placeholder('Анна')->maxLength(255),
                    TextInput::make('review_1.subtitle')->label('Подпись')->placeholder('6 месяцев терапии')->maxLength(255),
                    Textarea::make('review_1.body')->label('Текст отзыва')->rows(4),
                    Toggle::make('review_1.is_visible')->label('Показывать')->default(true),
                ]),

            Section::make('Отзыв 2')
                ->schema([
                    TextInput::make('review_2.title')->label('Имя клиента')->placeholder('Михаил')->maxLength(255),
                    TextInput::make('review_2.subtitle')->label('Подпись')->placeholder('8 месяцев терапии')->maxLength(255),
                    Textarea::make('review_2.body')->label('Текст отзыва')->rows(4),
                    Toggle::make('review_2.is_visible')->label('Показывать')->default(true),
                ]),

            Section::make('Отзыв 3')
                ->schema([
                    TextInput::make('review_3.title')->label('Имя клиента')->placeholder('Елена')->maxLength(255),
                    TextInput::make('review_3.subtitle')->label('Подпись')->placeholder('1 год терапии')->maxLength(255),
                    Textarea::make('review_3.body')->label('Текст отзыва')->rows(4),
                    Toggle::make('review_3.is_visible')->label('Показывать')->default(true),
                ]),
        ];
    }
}

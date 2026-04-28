<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class BlogSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'blog';
    protected static ?string $navigationLabel = 'Блог';
    protected static ?string $title = 'Секция «Блог»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;
    protected static ?int $navigationSort = 7;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Заголовок секции')
                ->columns(2)
                ->schema([
                    TextInput::make('heading.badge')->label('Бейдж')->placeholder('Блог')->maxLength(255),
                    TextInput::make('heading.title')->label('Первая строка')->placeholder('Статьи и')->maxLength(255),
                    TextInput::make('heading.subtitle')->label('Вторая строка')->placeholder('заметки')->maxLength(255),
                    Toggle::make('heading.is_visible')->label('Показывать секцию')->default(true)->columnSpanFull(),
                ]),

            Section::make('Кнопка «Все статьи»')
                ->columns(2)
                ->schema([
                    TextInput::make('cta_all.button_text')->label('Текст кнопки')->placeholder('Все статьи')->maxLength(255),
                    TextInput::make('cta_all.button_url')->label('Ссылка')->placeholder('#')->maxLength(255),
                ]),

            Section::make('Статья 1')
                ->schema([
                    TextInput::make('article_1.badge')->label('Категория')->placeholder('Терапия')->maxLength(100),
                    TextInput::make('article_1.title')->label('Заголовок')->maxLength(255),
                    Textarea::make('article_1.body')->label('Краткое описание')->rows(2),
                    TextInput::make('article_1.meta.date')->label('Дата публикации')->placeholder('15 января 2024')->maxLength(100),
                    TextInput::make('article_1.meta.readTime')->label('Время чтения')->placeholder('5 мин')->maxLength(50),
                    Toggle::make('article_1.is_visible')->label('Показывать')->default(true),
                ]),

            Section::make('Статья 2')
                ->schema([
                    TextInput::make('article_2.badge')->label('Категория')->placeholder('Советы')->maxLength(100),
                    TextInput::make('article_2.title')->label('Заголовок')->maxLength(255),
                    Textarea::make('article_2.body')->label('Краткое описание')->rows(2),
                    TextInput::make('article_2.meta.date')->label('Дата публикации')->placeholder('8 января 2024')->maxLength(100),
                    TextInput::make('article_2.meta.readTime')->label('Время чтения')->placeholder('4 мин')->maxLength(50),
                    Toggle::make('article_2.is_visible')->label('Показывать')->default(true),
                ]),

            Section::make('Статья 3')
                ->schema([
                    TextInput::make('article_3.badge')->label('Категория')->placeholder('Кризисы')->maxLength(100),
                    TextInput::make('article_3.title')->label('Заголовок')->maxLength(255),
                    Textarea::make('article_3.body')->label('Краткое описание')->rows(2),
                    TextInput::make('article_3.meta.date')->label('Дата публикации')->placeholder('20 декабря 2023')->maxLength(100),
                    TextInput::make('article_3.meta.readTime')->label('Время чтения')->placeholder('6 мин')->maxLength(50),
                    Toggle::make('article_3.is_visible')->label('Показывать')->default(true),
                ]),
        ];
    }
}

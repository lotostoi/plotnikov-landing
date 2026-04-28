<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class FaqSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'faq';
    protected static ?string $navigationLabel = 'FAQ';
    protected static ?string $title = 'Секция «Часто задаваемые вопросы»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;
    protected static ?int $navigationSort = 8;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Заголовок секции')
                ->columns(2)
                ->schema([
                    TextInput::make('heading.badge')->label('Бейдж')->placeholder('FAQ')->maxLength(255),
                    TextInput::make('heading.title')->label('Первая строка')->placeholder('Частые')->maxLength(255),
                    TextInput::make('heading.subtitle')->label('Вторая строка')->placeholder('вопросы')->maxLength(255),
                    Textarea::make('heading.body')->label('Подзаголовок')->rows(2)->columnSpanFull(),
                    Toggle::make('heading.is_visible')->label('Показывать секцию')->default(true)->columnSpanFull(),
                ]),

            Section::make('Вопрос 1')->schema([
                TextInput::make('faq_1.title')->label('Вопрос')->maxLength(500),
                Textarea::make('faq_1.body')->label('Ответ')->rows(4),
                Toggle::make('faq_1.is_visible')->label('Показывать')->default(true),
            ]),
            Section::make('Вопрос 2')->schema([
                TextInput::make('faq_2.title')->label('Вопрос')->maxLength(500),
                Textarea::make('faq_2.body')->label('Ответ')->rows(4),
                Toggle::make('faq_2.is_visible')->label('Показывать')->default(true),
            ]),
            Section::make('Вопрос 3')->schema([
                TextInput::make('faq_3.title')->label('Вопрос')->maxLength(500),
                Textarea::make('faq_3.body')->label('Ответ')->rows(4),
                Toggle::make('faq_3.is_visible')->label('Показывать')->default(true),
            ]),
            Section::make('Вопрос 4')->schema([
                TextInput::make('faq_4.title')->label('Вопрос')->maxLength(500),
                Textarea::make('faq_4.body')->label('Ответ')->rows(4),
                Toggle::make('faq_4.is_visible')->label('Показывать')->default(true),
            ]),
            Section::make('Вопрос 5')->schema([
                TextInput::make('faq_5.title')->label('Вопрос')->maxLength(500),
                Textarea::make('faq_5.body')->label('Ответ')->rows(4),
                Toggle::make('faq_5.is_visible')->label('Показывать')->default(true),
            ]),
            Section::make('Вопрос 6')->schema([
                TextInput::make('faq_6.title')->label('Вопрос')->maxLength(500),
                Textarea::make('faq_6.body')->label('Ответ')->rows(4),
                Toggle::make('faq_6.is_visible')->label('Показывать')->default(true),
            ]),
            Section::make('Вопрос 7')->schema([
                TextInput::make('faq_7.title')->label('Вопрос')->maxLength(500),
                Textarea::make('faq_7.body')->label('Ответ')->rows(4),
                Toggle::make('faq_7.is_visible')->label('Показывать')->default(true),
            ]),
            Section::make('Вопрос 8')->schema([
                TextInput::make('faq_8.title')->label('Вопрос')->maxLength(500),
                Textarea::make('faq_8.body')->label('Ответ')->rows(4),
                Toggle::make('faq_8.is_visible')->label('Показывать')->default(true),
            ]),
        ];
    }
}

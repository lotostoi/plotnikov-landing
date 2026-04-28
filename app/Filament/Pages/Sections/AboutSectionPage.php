<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class AboutSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'about';
    protected static ?string $navigationLabel = 'Обо мне';
    protected static ?string $title = 'Секция «Обо мне»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;
    protected static ?int $navigationSort = 3;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Заголовок секции')
                ->columns(2)
                ->schema([
                    TextInput::make('heading.badge')
                        ->label('Бейдж')
                        ->placeholder('Обо мне')
                        ->maxLength(255),
                    TextInput::make('heading.title')
                        ->label('Первая строка заголовка')
                        ->placeholder('Немного')
                        ->maxLength(255),
                    TextInput::make('heading.subtitle')
                        ->label('Вторая строка заголовка')
                        ->placeholder('обо мне')
                        ->maxLength(255),
                    Toggle::make('heading.is_visible')
                        ->label('Показывать секцию')
                        ->default(true)
                        ->columnSpanFull(),
                ]),

            Section::make('Текстовые абзацы')
                ->schema([
                    Textarea::make('paragraph_1.body')
                        ->label('Первый абзац')
                        ->rows(4),
                    Textarea::make('paragraph_2.body')
                        ->label('Второй абзац')
                        ->rows(3),
                ]),

            Section::make('Карточки ценностей')
                ->description('4 карточки с иконками внизу секции')
                ->columns(2)
                ->schema([
                    TextInput::make('value_1.title')->label('Карточка 1 — заголовок')->maxLength(255),
                    TextInput::make('value_1.label')->label('Карточка 1 — иконка (Lucide)')->placeholder('heart')->maxLength(100),
                    Textarea::make('value_1.body')->label('Карточка 1 — текст')->rows(2)->columnSpanFull(),

                    TextInput::make('value_2.title')->label('Карточка 2 — заголовок')->maxLength(255),
                    TextInput::make('value_2.label')->label('Карточка 2 — иконка (Lucide)')->placeholder('users')->maxLength(100),
                    Textarea::make('value_2.body')->label('Карточка 2 — текст')->rows(2)->columnSpanFull(),

                    TextInput::make('value_3.title')->label('Карточка 3 — заголовок')->maxLength(255),
                    TextInput::make('value_3.label')->label('Карточка 3 — иконка (Lucide)')->placeholder('briefcase')->maxLength(100),
                    Textarea::make('value_3.body')->label('Карточка 3 — текст')->rows(2)->columnSpanFull(),

                    TextInput::make('value_4.title')->label('Карточка 4 — заголовок')->maxLength(255),
                    TextInput::make('value_4.label')->label('Карточка 4 — иконка (Lucide)')->placeholder('sparkles')->maxLength(100),
                    Textarea::make('value_4.body')->label('Карточка 4 — текст')->rows(2)->columnSpanFull(),
                ]),
        ];
    }
}

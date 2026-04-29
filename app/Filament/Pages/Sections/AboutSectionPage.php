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

            Section::make('Слайд 1')
                ->description('Иконка — название из Lucide (например: message-circle, user, heart, flame, graduation-cap)')
                ->columns(2)
                ->collapsible()
                ->schema($this->slideSchema('slide_1', 'message-circle', 'Здравствуйте, я Александр')),

            Section::make('Слайд 2')
                ->columns(2)
                ->collapsible()
                ->collapsed()
                ->schema($this->slideSchema('slide_2', 'user', 'Немного обо мне')),

            Section::make('Слайд 3')
                ->columns(2)
                ->collapsible()
                ->collapsed()
                ->schema($this->slideSchema('slide_3', 'heart', 'Что важно для меня')),

            Section::make('Слайд 4')
                ->columns(2)
                ->collapsible()
                ->collapsed()
                ->schema($this->slideSchema('slide_4', 'flame', 'Мои кризисы')),

            Section::make('Слайд 5')
                ->columns(2)
                ->collapsible()
                ->collapsed()
                ->schema($this->slideSchema('slide_5', 'graduation-cap', 'Образование и опыт')),
        ];
    }

    /** @return array<mixed> */
    private function slideSchema(string $key, string $iconPlaceholder, string $titlePlaceholder): array
    {
        return [
            TextInput::make("{$key}.title")
                ->label('Заголовок слайда')
                ->placeholder($titlePlaceholder)
                ->maxLength(255)
                ->columnSpanFull(),

            TextInput::make("{$key}.label")
                ->label('Иконка (Lucide)')
                ->placeholder($iconPlaceholder)
                ->maxLength(100),

            TextInput::make("{$key}.button_url")
                ->label('URL фотографии')
                ->placeholder('https://...')
                ->maxLength(1000),

            Textarea::make("{$key}.body")
                ->label('Текст слайда')
                ->helperText('Абзацы разделяйте пустой строкой (два Enter)')
                ->rows(6)
                ->columnSpanFull(),

            Toggle::make("{$key}.is_visible")
                ->label('Показывать слайд')
                ->default(true)
                ->columnSpanFull(),
        ];
    }
}

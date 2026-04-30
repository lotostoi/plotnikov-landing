<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class HeroSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'hero';
    protected static ?string $navigationLabel = 'Хиро';
    protected static ?string $title = 'Хиро-секция (главный экран)';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;
    protected static ?int $navigationSort = 2;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Фотография')
                ->description('Главное фото в хиро-секции. Если не загружено — используется фото по умолчанию.')
                ->schema([
                    FileUpload::make('heading.button_url')
                        ->label('Фото (портрет)')
                        ->image()
                        ->disk('public')
                        ->directory('hero')
                        ->imagePreviewHeight('200')
                        ->imageEditor()
                        ->imageEditorAspectRatios(['3:4', '2:3', null])
                        ->downloadable()
                        ->helperText('Рекомендуется портретная ориентация (3:4). Если пусто — используется фото по умолчанию.'),
                ]),

            Section::make('Заголовок')
                ->description('Главный текст на первом экране')
                ->columns(2)
                ->schema([
                    TextInput::make('heading.badge')
                        ->label('Бейдж (подпись над именем)')
                        ->placeholder('Гештальт-терапевт')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    TextInput::make('heading.title')
                        ->label('Первая строка заголовка')
                        ->placeholder('Здравствуйте,')
                        ->maxLength(255),
                    TextInput::make('heading.subtitle')
                        ->label('Вторая строка заголовка')
                        ->placeholder('я Александр')
                        ->maxLength(255),
                    Textarea::make('heading.body')
                        ->label('Описание / подзаголовок')
                        ->rows(3)
                        ->columnSpanFull(),
                    Toggle::make('heading.is_visible')
                        ->label('Показывать блок')
                        ->default(true)
                        ->columnSpanFull(),
                ]),

            Section::make('Кнопки')
                ->columns(2)
                ->schema([
                    TextInput::make('cta_primary.button_text')
                        ->label('Главная кнопка — текст')
                        ->placeholder('Бесплатный созвон 15 мин')
                        ->maxLength(255),
                    TextInput::make('cta_primary.button_url')
                        ->label('Главная кнопка — ссылка')
                        ->placeholder('#contacts')
                        ->maxLength(255),
                    TextInput::make('cta_secondary.button_text')
                        ->label('Вторичная кнопка — текст')
                        ->placeholder('Узнать больше')
                        ->maxLength(255),
                    TextInput::make('cta_secondary.button_url')
                        ->label('Вторичная кнопка — ссылка')
                        ->placeholder('#about')
                        ->maxLength(255),
                ]),

            Section::make('Бейдж формата')
                ->description('Маленький бейдж под кнопками')
                ->columns(2)
                ->schema([
                    TextInput::make('format_badge.label')
                        ->label('Подпись (мелким шрифтом)')
                        ->placeholder('Формат')
                        ->maxLength(255),
                    TextInput::make('format_badge.title')
                        ->label('Значение')
                        ->placeholder('Онлайн по всему миру')
                        ->maxLength(255),
                ]),

            Section::make('Статистика')
                ->description('Три числовых показателя под фото')
                ->columns(3)
                ->schema([
                    TextInput::make('stat_1.title')->label('Цифра 1')->placeholder('15+')->maxLength(50),
                    TextInput::make('stat_2.title')->label('Цифра 2')->placeholder('12+')->maxLength(50),
                    TextInput::make('stat_3.title')->label('Цифра 3')->placeholder('10+')->maxLength(50),
                    TextInput::make('stat_1.subtitle')->label('Подпись 1')->placeholder('лет в психологии')->maxLength(255),
                    TextInput::make('stat_2.subtitle')->label('Подпись 2')->placeholder('лет личной терапии')->maxLength(255),
                    TextInput::make('stat_3.subtitle')->label('Подпись 3')->placeholder('лет групповой')->maxLength(255),
                ]),
        ];
    }
}

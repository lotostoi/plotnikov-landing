<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class HeaderSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'header';
    protected static ?string $navigationLabel = 'Шапка';
    protected static ?string $title = 'Шапка сайта';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBars3;
    protected static ?int $navigationSort = 1;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Бренд / Логотип')
                ->description('Имя и должность в левом углу шапки')
                ->columns(2)
                ->schema([
                    TextInput::make('brand.title')
                        ->label('Имя')
                        ->placeholder('Александр')
                        ->maxLength(255),
                    TextInput::make('brand.subtitle')
                        ->label('Должность / подпись')
                        ->placeholder('психолог')
                        ->maxLength(255),
                    Toggle::make('brand.is_visible')
                        ->label('Показывать')
                        ->default(true)
                        ->columnSpanFull(),
                ]),

            Section::make('Кнопка в шапке')
                ->description('Кнопка «Записаться» в правом углу')
                ->columns(2)
                ->schema([
                    TextInput::make('cta.button_text')
                        ->label('Текст кнопки')
                        ->placeholder('Записаться')
                        ->maxLength(255),
                    TextInput::make('cta.button_url')
                        ->label('Ссылка')
                        ->placeholder('#contacts')
                        ->maxLength(255),
                    Toggle::make('cta.is_visible')
                        ->label('Показывать')
                        ->default(true)
                        ->columnSpanFull(),
                ]),

            Section::make('Навигационное меню')
                ->description('Пункты меню в шапке')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('nav_about.label')->label('Обо мне — текст')->maxLength(255),
                        TextInput::make('nav_about.button_url')->label('Обо мне — ссылка')->maxLength(255),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('nav_services.label')->label('Услуги — текст')->maxLength(255),
                        TextInput::make('nav_services.button_url')->label('Услуги — ссылка')->maxLength(255),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('nav_education.label')->label('Образование — текст')->maxLength(255),
                        TextInput::make('nav_education.button_url')->label('Образование — ссылка')->maxLength(255),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('nav_reviews.label')->label('Отзывы — текст')->maxLength(255),
                        TextInput::make('nav_reviews.button_url')->label('Отзывы — ссылка')->maxLength(255),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('nav_blog.label')->label('Блог — текст')->maxLength(255),
                        TextInput::make('nav_blog.button_url')->label('Блог — ссылка')->maxLength(255),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('nav_faq.label')->label('FAQ — текст')->maxLength(255),
                        TextInput::make('nav_faq.button_url')->label('FAQ — ссылка')->maxLength(255),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('nav_contacts.label')->label('Контакты — текст')->maxLength(255),
                        TextInput::make('nav_contacts.button_url')->label('Контакты — ссылка')->maxLength(255),
                    ]),
                ]),
        ];
    }
}

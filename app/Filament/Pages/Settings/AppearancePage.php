<?php

declare(strict_types=1);

namespace App\Filament\Pages\Settings;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class AppearancePage extends BaseSettingsPage
{
    protected static ?string $navigationLabel = 'Внешний вид';
    protected static ?string $title = 'Внешний вид и видимость секций';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;
    protected static ?int $navigationSort = 4;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Тема сайта')
                ->schema([
                    Select::make('default_theme')
                        ->label('Тема по умолчанию')
                        ->options([
                            'warm' => 'Тёплая (warm)',
                            'dark' => 'Тёмная (dark)',
                        ])
                        ->default('warm')
                        ->required()
                        ->helperText('Применяется для новых посетителей. Если у пользователя уже выбрана тема — она сохраняется в браузере.'),
                ]),

            Section::make('Видимость секций')
                ->description('Скрытые секции не отображаются на сайте.')
                ->columns(2)
                ->schema([
                    Toggle::make('show_header')->label('Шапка (Header)')->default(true),
                    Toggle::make('show_hero')->label('Главный экран (Hero)')->default(true),
                    Toggle::make('show_about')->label('Обо мне')->default(true),
                    Toggle::make('show_services')->label('Услуги')->default(true),
                    Toggle::make('show_education')->label('Образование')->default(true),
                    Toggle::make('show_reviews')->label('Отзывы')->default(true),
                    Toggle::make('show_blog')->label('Блог')->default(true),
                    Toggle::make('show_faq')->label('FAQ')->default(true),
                    Toggle::make('show_contacts')->label('Контакты')->default(true),
                    Toggle::make('show_footer')->label('Футер')->default(true),
                ]),
        ];
    }
}

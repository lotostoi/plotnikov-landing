<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class FooterSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'footer';
    protected static ?string $navigationLabel = 'Футер';
    protected static ?string $title = 'Футер (подвал сайта)';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowDown;
    protected static ?int $navigationSort = 10;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Бренд в подвале')
                ->columns(2)
                ->schema([
                    TextInput::make('brand.title')->label('Имя')->placeholder('Александр')->maxLength(255),
                    TextInput::make('brand.subtitle')->label('Должность')->placeholder('психолог')->maxLength(255),
                    Textarea::make('brand.body')->label('Описание под именем')->rows(3)->columnSpanFull(),
                    Toggle::make('brand.is_visible')->label('Показывать блок')->default(true)->columnSpanFull(),
                ]),

            Section::make('Копирайт')
                ->schema([
                    Textarea::make('copyright.body')
                        ->label('Текст копирайта')
                        ->placeholder('Сделано с любовью во Владивостоке')
                        ->rows(2),
                ]),
        ];
    }
}

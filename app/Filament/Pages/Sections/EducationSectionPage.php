<?php

declare(strict_types=1);

namespace App\Filament\Pages\Sections;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class EducationSectionPage extends BaseSectionPage
{
    protected static string $sectionCode = 'education';
    protected static ?string $navigationLabel = 'Образование';
    protected static ?string $title = 'Секция «Образование»';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static ?int $navigationSort = 5;

    protected function getFormComponents(): array
    {
        return [
            Section::make('Заголовок секции')
                ->columns(2)
                ->schema([
                    TextInput::make('heading.badge')->label('Бейдж')->placeholder('Образование')->maxLength(255),
                    TextInput::make('heading.title')->label('Первая строка')->placeholder('Опыт и')->maxLength(255),
                    TextInput::make('heading.subtitle')->label('Вторая строка')->placeholder('образование')->maxLength(255),
                    Toggle::make('heading.is_visible')->label('Показывать секцию')->default(true)->columnSpanFull(),
                ]),

            Section::make('Учебные заведения')
                ->columns(2)
                ->schema([
                    TextInput::make('edu_1.title')->label('Учёба 1 — название')->maxLength(255),
                    TextInput::make('edu_1.subtitle')->label('Учёба 1 — уточнение')->maxLength(255),
                    TextInput::make('edu_1.badge')->label('Учёба 1 — статус')->placeholder('Завершено')->maxLength(100),
                    TextInput::make('edu_1.label')->label('Учёба 1 — иконка (Lucide)')->placeholder('graduation-cap')->maxLength(100),

                    TextInput::make('edu_2.title')->label('Учёба 2 — название')->maxLength(255),
                    TextInput::make('edu_2.subtitle')->label('Учёба 2 — уточнение')->maxLength(255),
                    TextInput::make('edu_2.badge')->label('Учёба 2 — статус')->placeholder('В процессе')->maxLength(100),
                    TextInput::make('edu_2.label')->label('Учёба 2 — иконка (Lucide)')->placeholder('book-open')->maxLength(100),
                ]),

            Section::make('Опыт (числовые показатели)')
                ->columns(2)
                ->schema([
                    TextInput::make('exp_1.title')->label('Опыт 1 — цифра')->placeholder('12+')->maxLength(50),
                    TextInput::make('exp_1.subtitle')->label('Опыт 1 — подпись')->placeholder('лет личной терапии')->maxLength(255),
                    TextInput::make('exp_1.body')->label('Опыт 1 — уточнение')->placeholder('с перерывами')->maxLength(255),
                    TextInput::make('exp_1.label')->label('Опыт 1 — иконка')->placeholder('clock')->maxLength(100),

                    TextInput::make('exp_2.title')->label('Опыт 2 — цифра')->placeholder('10')->maxLength(50),
                    TextInput::make('exp_2.subtitle')->label('Опыт 2 — подпись')->placeholder('лет групповой терапии')->maxLength(255),
                    TextInput::make('exp_2.body')->label('Опыт 2 — уточнение')->placeholder('регулярное участие')->maxLength(255),
                    TextInput::make('exp_2.label')->label('Опыт 2 — иконка')->placeholder('users')->maxLength(100),
                ]),

            Section::make('Подходы (теги / чипы)')
                ->columns(2)
                ->schema([
                    TextInput::make('approach_1.title')->label('Подход 1')->maxLength(255),
                    TextInput::make('approach_2.title')->label('Подход 2')->maxLength(255),
                    TextInput::make('approach_3.title')->label('Подход 3')->maxLength(255),
                    TextInput::make('approach_4.title')->label('Подход 4')->maxLength(255),
                ]),
        ];
    }
}

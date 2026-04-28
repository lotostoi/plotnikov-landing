<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\EducationBlocksResource\Pages\CreateEducationBlock;
use App\Filament\Resources\ContentSections\EducationBlocksResource\Pages\EditEducationBlock;
use App\Filament\Resources\ContentSections\EducationBlocksResource\Pages\ListEducationBlocks;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EducationBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Образование';
    protected static ?int $navigationSort = 14;

    protected static function sectionCode(): string
    {
        return 'education';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Тип и ключ')
                ->columns(3)
                ->schema([
                    TextInput::make('block_key')
                        ->label('Ключ')
                        ->required()
                        ->maxLength(255)
                        ->helperText('heading, edu_1, edu_2, exp_1, exp_2, approach_1…'),
                    TextInput::make('block_type')
                        ->label('Тип')
                        ->required()
                        ->maxLength(100)
                        ->helperText('text, card, stat, chip'),
                    TextInput::make('sort_order')
                        ->label('Порядок')
                        ->numeric()
                        ->default(100)
                        ->required(),
                ]),

            Section::make('Содержимое')
                ->columns(2)
                ->schema([
                    TextInput::make('badge')
                        ->label('Статус / Бейдж')
                        ->maxLength(255)
                        ->helperText('Для edu: Завершено / В процессе'),
                    TextInput::make('label')
                        ->label('Иконка (Lucide)')
                        ->maxLength(255)
                        ->helperText('graduation-cap, book-open, clock, users'),
                    TextInput::make('title')
                        ->label('Название / Значение')
                        ->maxLength(255)
                        ->helperText('Для edu — название учреждения; для exp — цифра (12+)'),
                    TextInput::make('subtitle')
                        ->label('Учреждение / Подпись')
                        ->maxLength(255)
                        ->helperText('Для edu — учреждение; для exp — label'),
                    Textarea::make('body')
                        ->label('Уточнение (body)')
                        ->rows(3)
                        ->columnSpanFull()
                        ->helperText('Для chip (подход) — не нужно; для stat — пояснение (с перерывами)'),
                ]),

            Section::make('Фото секции «Образование»')
                ->description('Только для блока heading. Загрузите фото или укажите внешний URL.')
                ->columns(2)
                ->schema([
                    FileUpload::make('meta.image_path')
                        ->label('Загрузить фото')
                        ->image()
                        ->disk('public')
                        ->directory('education')
                        ->maxSize(5120),
                    TextInput::make('meta.image_url')
                        ->label('Или внешний URL фото')
                        ->url()
                        ->maxLength(500),
                ]),

            Toggle::make('is_visible')
                ->label('Показывать блок')
                ->default(true),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListEducationBlocks::route('/'),
            'create' => CreateEducationBlock::route('/create'),
            'edit'   => EditEducationBlock::route('/{record}/edit'),
        ];
    }
}

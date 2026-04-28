<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\HeroBlocksResource\Pages\CreateHeroBlock;
use App\Filament\Resources\ContentSections\HeroBlocksResource\Pages\EditHeroBlock;
use App\Filament\Resources\ContentSections\HeroBlocksResource\Pages\ListHeroBlocks;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HeroBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Хиро';
    protected static ?int $navigationSort = 11;

    protected static function sectionCode(): string
    {
        return 'hero';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Тип и ключ блока')
                ->columns(3)
                ->schema([
                    TextInput::make('block_key')
                        ->label('Ключ')
                        ->required()
                        ->maxLength(255)
                        ->helperText('heading, cta_primary, cta_secondary, format_badge, stat_1…'),
                    TextInput::make('block_type')
                        ->label('Тип')
                        ->required()
                        ->maxLength(100)
                        ->helperText('text, cta, badge, stat'),
                    TextInput::make('sort_order')
                        ->label('Порядок')
                        ->numeric()
                        ->default(100)
                        ->required(),
                ]),

            Section::make('Заголовок / Текст')
                ->columns(2)
                ->schema([
                    TextInput::make('badge')
                        ->label('Бейдж (badge)')
                        ->placeholder('Гештальт-терапевт')
                        ->maxLength(255),
                    TextInput::make('label')
                        ->label('Label (для format_badge — подпись)')
                        ->maxLength(255),
                    TextInput::make('title')
                        ->label('Заголовок (title)')
                        ->placeholder('Здравствуйте,')
                        ->maxLength(255),
                    TextInput::make('subtitle')
                        ->label('Подзаголовок (subtitle)')
                        ->placeholder('я Александр')
                        ->maxLength(255),
                    Textarea::make('body')
                        ->label('Основной текст (body)')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Section::make('Кнопка / Ссылка')
                ->columns(2)
                ->schema([
                    TextInput::make('button_text')
                        ->label('Текст кнопки')
                        ->maxLength(255),
                    TextInput::make('button_url')
                        ->label('Ссылка')
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
            'index'  => ListHeroBlocks::route('/'),
            'create' => CreateHeroBlock::route('/create'),
            'edit'   => EditHeroBlock::route('/{record}/edit'),
        ];
    }
}

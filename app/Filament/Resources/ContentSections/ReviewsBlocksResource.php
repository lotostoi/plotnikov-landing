<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\ReviewsBlocksResource\Pages\CreateReviewsBlock;
use App\Filament\Resources\ContentSections\ReviewsBlocksResource\Pages\EditReviewsBlock;
use App\Filament\Resources\ContentSections\ReviewsBlocksResource\Pages\ListReviewsBlocks;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReviewsBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Отзывы';
    protected static ?int $navigationSort = 15;

    protected static function sectionCode(): string
    {
        return 'reviews';
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
                        ->helperText('heading, review_1, review_2, review_3…'),
                    TextInput::make('block_type')
                        ->label('Тип')
                        ->required()
                        ->maxLength(100)
                        ->helperText('text, review'),
                    TextInput::make('sort_order')
                        ->label('Порядок')
                        ->numeric()
                        ->default(100)
                        ->required(),
                ]),

            Section::make('Данные отзыва')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Имя клиента')
                        ->placeholder('Анна')
                        ->maxLength(255),
                    TextInput::make('subtitle')
                        ->label('Период / Детали')
                        ->placeholder('6 месяцев терапии')
                        ->maxLength(255),
                    Textarea::make('body')
                        ->label('Текст отзыва')
                        ->rows(6)
                        ->columnSpanFull(),
                ]),

            Toggle::make('is_visible')
                ->label('Показывать блок')
                ->default(true),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListReviewsBlocks::route('/'),
            'create' => CreateReviewsBlock::route('/create'),
            'edit'   => EditReviewsBlock::route('/{record}/edit'),
        ];
    }
}

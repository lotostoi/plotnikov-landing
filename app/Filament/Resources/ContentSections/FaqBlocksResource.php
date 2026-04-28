<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\FaqBlocksResource\Pages\CreateFaqBlock;
use App\Filament\Resources\ContentSections\FaqBlocksResource\Pages\EditFaqBlock;
use App\Filament\Resources\ContentSections\FaqBlocksResource\Pages\ListFaqBlocks;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'FAQ';
    protected static ?int $navigationSort = 17;

    protected static function sectionCode(): string
    {
        return 'faq';
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
                        ->helperText('heading, faq_1, faq_2, faq_3…'),
                    TextInput::make('block_type')
                        ->label('Тип')
                        ->required()
                        ->maxLength(100)
                        ->helperText('text, faq'),
                    TextInput::make('sort_order')
                        ->label('Порядок')
                        ->numeric()
                        ->default(100)
                        ->required(),
                ]),

            Section::make('Вопрос и ответ')
                ->schema([
                    TextInput::make('title')
                        ->label('Вопрос')
                        ->maxLength(500)
                        ->columnSpanFull(),
                    Textarea::make('body')
                        ->label('Ответ')
                        ->rows(6),
                ]),

            Toggle::make('is_visible')
                ->label('Показывать')
                ->default(true),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListFaqBlocks::route('/'),
            'create' => CreateFaqBlock::route('/create'),
            'edit'   => EditFaqBlock::route('/{record}/edit'),
        ];
    }
}

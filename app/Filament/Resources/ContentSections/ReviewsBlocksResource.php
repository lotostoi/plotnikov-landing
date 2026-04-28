<?php

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\ReviewsBlocksResource\Pages\ManageReviewsBlocks;

class ReviewsBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Отзывы';
    protected static ?int $navigationSort = 15;

    protected static function sectionCode(): string
    {
        return 'reviews';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageReviewsBlocks::route('/'),
        ];
    }
}


<?php

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\FaqBlocksResource\Pages\ManageFaqBlocks;

class FaqBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'FAQ';
    protected static ?int $navigationSort = 17;

    protected static function sectionCode(): string
    {
        return 'faq';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFaqBlocks::route('/'),
        ];
    }
}


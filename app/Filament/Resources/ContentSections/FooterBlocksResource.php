<?php

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\FooterBlocksResource\Pages\ManageFooterBlocks;

class FooterBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Футер';
    protected static ?int $navigationSort = 19;

    protected static function sectionCode(): string
    {
        return 'footer';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFooterBlocks::route('/'),
        ];
    }
}


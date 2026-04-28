<?php

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\HeaderBlocksResource\Pages\ManageHeaderBlocks;

class HeaderBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Шапка';
    protected static ?int $navigationSort = 10;

    protected static function sectionCode(): string
    {
        return 'header';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHeaderBlocks::route('/'),
        ];
    }
}


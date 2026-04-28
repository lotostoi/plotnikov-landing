<?php

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\AboutBlocksResource\Pages\ManageAboutBlocks;

class AboutBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Обо мне';
    protected static ?int $navigationSort = 12;

    protected static function sectionCode(): string
    {
        return 'about';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAboutBlocks::route('/'),
        ];
    }
}


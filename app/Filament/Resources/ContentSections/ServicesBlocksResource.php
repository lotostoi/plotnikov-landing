<?php

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\ServicesBlocksResource\Pages\ManageServicesBlocks;

class ServicesBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Услуги';
    protected static ?int $navigationSort = 13;

    protected static function sectionCode(): string
    {
        return 'services';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageServicesBlocks::route('/'),
        ];
    }
}


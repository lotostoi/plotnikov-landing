<?php

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\EducationBlocksResource\Pages\ManageEducationBlocks;

class EducationBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Образование';
    protected static ?int $navigationSort = 14;

    protected static function sectionCode(): string
    {
        return 'education';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageEducationBlocks::route('/'),
        ];
    }
}


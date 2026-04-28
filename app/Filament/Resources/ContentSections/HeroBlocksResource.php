<?php

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\HeroBlocksResource\Pages\ManageHeroBlocks;

class HeroBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Хиро';
    protected static ?int $navigationSort = 11;

    protected static function sectionCode(): string
    {
        return 'hero';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHeroBlocks::route('/'),
        ];
    }
}


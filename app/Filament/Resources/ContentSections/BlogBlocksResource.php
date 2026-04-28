<?php

namespace App\Filament\Resources\ContentSections;

use App\Filament\Resources\ContentSections\BlogBlocksResource\Pages\ManageBlogBlocks;

class BlogBlocksResource extends BaseSectionBlocksResource
{
    protected static ?string $navigationLabel = 'Блог';
    protected static ?int $navigationSort = 16;

    protected static function sectionCode(): string
    {
        return 'blog';
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBlogBlocks::route('/'),
        ];
    }
}


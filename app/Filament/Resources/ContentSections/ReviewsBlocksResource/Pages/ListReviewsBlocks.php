<?php

namespace App\Filament\Resources\ContentSections\ReviewsBlocksResource\Pages;

use App\Filament\Resources\ContentSections\ReviewsBlocksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReviewsBlocks extends ListRecords
{
    protected static string $resource = ReviewsBlocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Добавить блок'),
        ];
    }
}
